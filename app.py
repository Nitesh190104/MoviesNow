from flask import Flask, request
import requests
import sqlite3
from flask_cors import CORS  # ✅ To allow PHP to talk to Flask

app = Flask(__name__)
CORS(app)  # 🔓 Allow access from your PHP frontend

GROQ_API_KEY = "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"

def get_response_from_groq(user_input):
    headers = {
        "Authorization": f"Bearer {GROQ_API_KEY}",
        "Content-Type": "application/json"
    }

    data = {
        "messages": [
            {"role": "system", "content": "You are a smart assistant for an online ticket booking platform. You help users book tickets for movies, shows, concert, sports events and many more. You can assist with queries like ticket availability, booking steps, cancellation policy, and timings. Politely inform users that you cannot process payments or bookings directly, and suggest they use the official portal for final steps, and most important thing do not respond on any other topic. if user ask any other topic simply say 'I am not able to help you with this topic, please ask me about ticket booking or related topics'."},
            {"role": "user", "content": user_input}
        ],
        "model": "llama3-8b-8192",
    }

    response = requests.post("https://api.groq.com/openai/v1/chat/completions", headers=headers, json=data)
    return response.json()['choices'][0]['message']['content']



@app.route("/get", methods=["GET"])
def get_bot_response():
    user_input = request.args.get("msg")

    # Optional restriction: no payment/card info
    restricted_keywords = ["credit card", "debit card", "payment", "CVV", "bank"]
    if any(word in user_input.lower() for word in restricted_keywords):
        return "⚠️ For security reasons, please don't share any payment or card information here."

    response = get_response_from_groq(user_input)
    return response


if __name__ == "__main__":
    app.run(debug=True)

