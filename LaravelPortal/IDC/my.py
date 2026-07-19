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

if __name__ == "__main__":
    model_path = 'Brest_CNN.h5'
    loaded_model = load_trained_model(model_path)

    if loaded_model:
        live_detection(loaded_model)
