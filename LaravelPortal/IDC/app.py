from flask import Flask, render_template, request, jsonify, Response, redirect, url_for
import tensorflow as tf
import cv2
import numpy as np
import base64

app = Flask(__name__)

# Load the trained model
model = tf.keras.models.load_model("Brest_CNN.h5")

# Initialize the camera
camera = cv2.VideoCapture(0)

def generate_frames():
    while True:
        success, frame = camera.read()
        if not success:
            break
        else:
            ret, buffer = cv2.imencode('.jpg', frame)
            frame = buffer.tobytes()
            yield (b'--frame\r\n'
                    b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/predict', methods=['POST'])
def predict():
    if request.method == 'POST':
        results = []
        files = request.files.getlist('file')

        if not any(files):  # Check if no file is selected
            return render_template('index.html', error="Please select a file for prediction")

        for file in files:
            # Check if a file is uploaded
            if file.filename == '':
                continue

            img = cv2.imdecode(np.fromstring(file.read(), np.uint8), cv2.IMREAD_COLOR)
            img = cv2.resize(img, (50, 50))
            img = np.reshape(img, [1, 50, 50, 3])

            prediction = model.predict(img)
            result = int(np.argmax(prediction))

            results.append({'filename': file.filename, 'result': result})

        return render_template('index.html', results=results)

@app.route('/live')
def live():
    import cv2
    import numpy as np
    from tensorflow.keras.models import load_model

    def load_trained_model(model_path):
        try:
            model = load_model(model_path)
            print("Model loaded successfully!")
            return model
        except Exception as e:
            print(f"Error loading the model: {e}")
            return None

    def preprocess_frame(frame, target_size=(50, 50)):
        input_frame = cv2.resize(frame, target_size)
        input_frame = np.expand_dims(input_frame, axis=0)
        return input_frame / 255.0

    def get_prediction(model, input_frame):
        prediction = model.predict(input_frame)
        return np.argmax(prediction)

    def display_result(frame, predicted_class):
        result_text = "Negative" if predicted_class == 0 else "Positive"
        cv2.putText(frame, result_text, (50, 50), cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2)
        return frame

    def live_detection(model):
        cap = cv2.VideoCapture(0)

        while True:
            ret, frame = cap.read()

            input_frame = preprocess_frame(frame)
            predicted_class = get_prediction(model, input_frame)
            frame_with_result = display_result(frame.copy(), predicted_class)

            cv2.imshow('Live Detection', frame_with_result)

            key = cv2.waitKey(1)
            if key == ord('q') or key == ord('d'):
                break

        cap.release()
        cv2.destroyAllWindows()

    model_path = 'Brest_CNN.h5'
    loaded_model = load_trained_model(model_path)

    if loaded_model:
        live_detection(loaded_model)

    # Add a return statement here to avoid the TypeError
    return redirect(url_for('index'))

@app.route('/video_feed')
def video_feed():
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

@app.route('/predict-live', methods=['POST'])
def predict_live():
    if request.method == 'POST':
        image_data = request.json.get('image_data')

        # Decode base64 image data
        encoded_data = image_data.split(',')[1]
        decoded_data = base64.b64decode(encoded_data)
        nparr = np.frombuffer(decoded_data, np.uint8)
        img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)

        # Resize image
        img = cv2.resize(img, (50, 50))
        img = np.reshape(img, [1, 50, 50, 3])

        # Make a prediction
        prediction = model.predict(img)
        result = int(np.argmax(prediction))  # Convert to standard Python int

        # Return the result as JSON
        return jsonify({'result': result})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
