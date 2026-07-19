# IPR Working Notes — for Khadija to write from (not to copy verbatim)

Module 7COM1039-0509-2025 · **Due Mon 20 Jul 2026, 16:00** · Report 8–14 pages · Submit as one file named `<studentnumber>-Ibrahim-IPR.pdf/docx`

**GenAI rule on the assignment page:** AI tools may only proofread; they may not create content. Everything below is reference material and prompts — Khadija needs to write the actual sentences herself, and should declare any AI proofreading tool she uses.

---

## 0. Important gap to resolve first

The DPP (submitted under supervisor Sydney Ezika) describes an ambitious 2026-style system: attention-guided/foundation-model-inspired architecture, XAI region-attribution maps, a secure web app, Docker packaging, edge processing, clinical validation against pathologists.

The actual artifacts in `TrainedModel/` are four Keras notebooks trained on the public Kaggle "Breast Histopathology Images" patch dataset:

| Model | Type | Test accuracy | Notes |
|---|---|---|---|
| **IDCNet** (custom CNN) | 3 conv blocks (32/64/128 filters) + BatchNorm + Dropout + Dense(128) + sigmoid, ~684.7K params | **96.74%** | ROC-AUC 0.98. Confusion matrix: TN 6210, FP 66, FN 176, TP 982 → IDC(–) recall 98.9%, IDC(+) recall (sensitivity) 84.8%. *This is likely where the "98.9" filename comes from — it's the negative-class recall, not overall accuracy. Be precise about this distinction in the report.* |
| **ResNet50** | Transfer learning, frozen base, GAP→Dense(256)→Dropout(0.5)→Dense(128)→Dropout(0.3)→sigmoid | ~89–90% (confirm exact figure from your notebook output) | Confusion matrix showed a noticeably weaker IDC(+) recall (~58%) than IDC(–) — worth flagging as a class-imbalance/sensitivity limitation. |
| **VGG19** | Transfer learning, frozen base + Dense(128)+BN+Dropout+sigmoid head | ~90% (confirm exact figure) | |
| **EfficientNetB0** | Transfer learning, same head pattern | ~89–90% (confirm exact figure) | |

All four: Adam (lr=0.0001), binary cross-entropy, 200 epochs, batch size 35, on-the-fly augmentation (rotation/shift/shear/zoom/flip), 50×50 RGB patches, dataset from Kaggle `paultimothymooney/breast-histopathology-images` (already referenced as [5] in the DPP).

**None of the following exist yet in the provided files:** web application, attention/XAI layer, Docker container, edge-processing pipeline, pathologist-benchmarked validation.

**Before writing Criteria 2 and 5, Khadija needs to decide (with her supervisor if unsure) how to frame this honestly:** e.g., "baseline model development and comparative evaluation is complete (Milestones 2–4); the attention/XAI and web-delivery components proposed in the DPP are the next phase" — rather than implying the full DPP vision is built. Markers are explicitly told to check the appendices for evidence (screenshots/code), so overstating progress is easy to catch and directly risks Criteria 2 (loses "outstanding/excellent" band) and academic integrity if it misrepresents work done.

**Pull exact metrics** for ResNet/VGG19/EfficientNet from her own notebook outputs (Read the .pdf/.ipynb screenshots) before finalizing the table above — don't rely on my approximations in the final report.

---

## 1. Criteria 1 — Background research & literature review (10 marks, 2–3 pages)

Markers want: goals/objectives/research question stated, then a *critical* (not just descriptive) review of 3–4 key sources, contrasting viewpoints, and how the literature shaped her approach.

Reusable from the DPP (already real, verified sources — see below):
- WHO breast cancer burden stats [1]
- Nassif et al. 2022 systematic review of AI breast cancer detection [2]
- Transfer-learning-based IDC detection papers [3][4]
- Shamai et al., *Lancet Oncology* 2026 — deep learning recurrence-risk prediction from H&E slides [8] ✅ verified real
- WEEP (WSI region-selection interpretability method), arXiv 2403.15238 ✅ verified real
- MDPI Applied Sciences 2025, morphologically-guided IDC classification ✅ verified real

Note the assignment brief explicitly allows reusing/refining DPP material *if it's referenced and still adds value* — cite it as her own earlier work, don't just re-paste.

Prompts only Khadija can answer:
- What is her **specific research question** now (has it narrowed since the DPP, e.g. toward comparative CNN architecture evaluation, or toward the privacy/security angle for an MSc Cyber Security module)?
- Which 3–4 papers did she *actually* read and critically engage with — where do they agree/disagree, and how did that shape a decision she made (e.g. why transfer learning over training from scratch, why patch-level vs whole-slide)?
- Any additional recent search needed on: class-imbalance handling in medical imaging, or privacy-preserving/on-device inference for clinical AI (this would strengthen the MSc Cyber Security framing).

---

## 2. Criteria 2 — Summary of progress to date (20 marks — heaviest weighting, 2–3 pages, needs appendix evidence)

Markers want: concrete completed tasks tied to DPP goals, tools/technologies used and justified, deliverables evidenced via appendices (screenshots, code, test logs), management approach, and honest handling of any challenges/scope changes.

Facts she can draw on (map to her actual DPP milestones):
- **Milestone 2 (Data Collection & Preprocessing):** Kaggle dataset acquired via Kaggle API in Colab; ~277K 50×50 patches; class balancing performed (IDC-negative subsampled to match IDC-positive count in the IDCNet notebook); train/test split 70/30 (note: DPP proposed 60/20/20 — flag/reconcile this discrepancy); pixel normalization (0–1); on-the-fly augmentation.
- **Milestone 3–4 (Algorithm Development & Model Training):** four architectures implemented and trained end-to-end — a custom CNN plus transfer learning with ResNet50, VGG19, EfficientNetB0; 200 epochs each; comparative evaluation via accuracy, confusion matrix, ROC-AUC.
- **Tools/tech used:** Python, TensorFlow/Keras, Google Colab (GPU), scikit-learn (metrics/splits), OpenCV (image I/O/resize), pandas/matplotlib/seaborn.
- **Not yet started:** web application (Milestone 5), system/stress testing (Milestone 6), pathologist-benchmarked validation (Milestone 7), documentation/containerization (Milestone 8).

Prompts only Khadija can answer:
- Actual hours spent so far (the brief expects ~280–300 hrs completed by this point) and how that maps to a timeline/Gantt she can show.
- What challenges did she hit — e.g. class imbalance, overfitting (worth checking: IDCNet's val_accuracy plateaus around 96–97% while training accuracy nears 99%, a possible mild overfitting signal worth discussing), GPU/Colab session limits, dataset licensing?
- What screenshots/code/logs will she put in appendices as evidence (notebook cells, training curves, confusion matrices — all already in the TrainedModel PDFs)?
- Has she chosen which model to carry forward as the primary "artifact" (IDCNet has the best raw accuracy but weaker interpretability than a transfer-learning backbone — worth a reasoned justification, not just "highest number wins").

---

## 3. Criteria 3 — Ethical, legal, professional, social issues (20 marks, a few paragraphs)

Markers want: current issues + how they might evolve as the project develops, across all four lenses.

Facts to reason from: the Kaggle dataset consists of de-identified histopathology patches from a public research repository (originally from a study by Janowczyk & Madabhushi) — not raw patient records, so no direct PII is processed here. That's a relevant starting point, not a full answer.

Prompts only Khadija can answer (needs her own reflection + university procedure references):
- **Ethical:** Does her university/module require formal ethics approval for use of a public, pre-anonymized secondary dataset? (Check with Sydney Ezika / the ethics approval process referenced in the DPP — "formalize ethics approvals" was listed as a Milestone 1 task; has this actually happened, and can it be evidenced?)
- **Legal:** GDPR relevance even for de-identified data reused in an AI pipeline; dataset licensing terms (Kaggle/Mendeley/BreakHis usage terms); IP considerations if reusing DPP/IPR content into the final report.
- **Professional:** Relevant standards, e.g. IEEE/BCS codes of conduct, clinical-AI-specific frameworks (e.g. FDA/MHRA guidance on AI as a diagnostic aid, "second opinion" positioning already used in her abstract).
- **Social:** Risk of bias/generalization failure across scanners/staining sites (already noted as a market limitation in her own DPP — connect it here); accessibility/equity implications of AI diagnostic tools in low-resource clinics (also already in her DPP language).
- How might these evolve if she adds the proposed web app or clinical deployment components — new risks (data-in-transit security, model inversion/re-identification risk, false-negative harm)?

This section is a strong natural fit for the **MSc Cyber Security** angle if her programme expects it — e.g. focusing depth on data protection/GDPR and secure handling of sensitive health data in the AI pipeline, since that's where "cyber security" concretely intersects with this project.

---

## 4. Criteria 4 — Project plan (15 marks, 1–2 pages, appendix evidence e.g. Gantt chart)

Markers want: remaining key tasks, deliverables per task, management approach (her DPP already claims a methodology — name it, e.g. Agile/hybrid), risk/quality handling, and a schedule to submission with time reserved for report writing and any final presentation/demo.

Remaining DPP milestones she can slot into a plan: Milestone 5 (web app), 6 (testing), 7 (validation/eval — sensitivity/specificity formally reported), 8 (documentation/packaging), plus final report writing time.

Prompts only Khadija can answer:
- What's actually feasible before the Final Report deadline given time remaining?
- Does she still intend to build the full web app + Docker packaging, or descope to a strictly model-evaluation-focused MSc Cyber Security deliverable (e.g. privacy-preserving inference, adversarial robustness testing of the trained models)? This decision should be made deliberately and stated, not left implicit.
- Gantt chart / dated milestones from today (19 Jul 2026) to submission.

---

## 5. Criteria 5 — Level of the project (15 marks)

Markers want critical reflection on: why this problem, depth of investigation, methods appropriateness for MSc level, testing/validation/experimentation plans, edge cases, and justification of tool choices.

Facts to use: she already has a genuine comparative-methods contribution — four architectures (1 custom, 3 transfer-learning) evaluated under identical training conditions, which is a legitimate MSc-level comparative investigation, not just "ran a tutorial." The class-imbalance sensitivity gap (ResNet's ~58% IDC+ recall vs IDCNet's ~85%) is a real, defensible finding to critically discuss — most projects at this level don't have their own genuine comparative result to lean on, so use it.

Prompts only Khadija can answer:
- Why does this problem interest her / connect to career goals?
- What edge cases has she considered or plans to test (e.g. stain-color variation, blurry/artifact patches, class imbalance at inference time)?
- Why these four architectures specifically, and why patch-level rather than whole-slide — justify against alternatives she read about in her lit review.

---

## 6. Criteria 6 — Referencing & in-text citation (10 marks)

- Use Harvard style consistently, alphabetical by surname in the reference list.
- The DPP references are usable and (spot-checked) real — see verified list below.
- Every technical claim/tool choice should be backed by a citation (e.g. cite Keras/TensorFlow, the Kaggle dataset, the architectures' original papers — VGG19: Simonyan & Zisserman 2014; ResNet: He et al. 2016; EfficientNet: Tan & Le 2019 — she should locate and cite the actual originating papers rather than just the framework docs).

---

## 7. Criteria 7 — Report presentation (10 marks)

Structure per the section order above, proofread for grammar/spelling (this is the one place a GenAI proofreading tool is explicitly permitted — just declare it), label all figures (confusion matrices, ROC curves, training curves — she has these already as images in the TrainedModel PDFs and can drop them straight into appendices).

---

## Verified references (checked via web search, 19 Jul 2026)

- Shamai, G., Cohen, S., Binenbaum, Y. et al. (2026) "Deep learning on histopathological images to predict breast cancer recurrence risk and chemotherapy benefit: a multicentre, model development and validation study," *The Lancet Oncology*. https://www.thelancet.com/journals/lanonc/article/PIIS1470-2045(25)00727-2/fulltext
- WEEP: "A method for spatial interpretation of weakly supervised CNN models in computational pathology," arXiv:2403.15238 / *Scientific Reports* (2025). https://arxiv.org/abs/2403.15238
- "Enhancing AI-Driven Diagnosis of Invasive Ductal Carcinoma with Morphologically Guided and Interpretable Deep Learning," *MDPI Applied Sciences*, 15(12), 6883 (2025). https://www.mdpi.com/2076-3417/15/12/6883
