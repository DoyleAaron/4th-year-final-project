import sys
import json
import joblib
import pandas as pd
import os

def main():
    if len(sys.argv) < 3:
        print("Usage: python predict.py '<json_input>' <model_filename>")
        return

    input_json = sys.argv[1]
    model_filename = sys.argv[2]

    try:
        input_data = json.loads(input_json)
    except json.JSONDecodeError:
        print("Invalid JSON input")
        return

    # Get full path to model
    base_dir = os.path.dirname(os.path.abspath(__file__))
    model_path = os.path.join(base_dir, 'app', 'ML', model_filename)

    try:
        model = joblib.load(model_path)
    except Exception as e:
        print(f"Error loading model: {e}")
        return

    input_df = pd.DataFrame([input_data])

    try:
        prediction = model.predict(input_df)
        print(prediction[0])
    except Exception as e:
        print(f"Prediction error: {e}")

if __name__ == "__main__":
    main()
