from flask import Flask, request, jsonify
import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

app = Flask(__name__)

GMAIL_USER = "diegolohi2@gmail.com"
GMAIL_PASSWORD = "tezxtubcgvbzfgjc"

@app.route('/send-email', methods=['POST'])
def send_email():
    destinatario = "blanfor67@gmail.com"
    asunto = "Asunto de prueba"
    mensaje = "Este es un mensaje de prueba."

    if not destinatario or not asunto or not mensaje:
        return jsonify({"error": "Faltan campos"}), 400

    try:
        # Crear el correo
        msg = MIMEMultipart()
        msg['From'] = GMAIL_USER
        msg['To'] = destinatario
        msg['Subject'] = asunto
        msg.attach(MIMEText(mensaje, 'plain'))

        # Conexión SMTP
        server = smtplib.SMTP('smtp.gmail.com', 587)
        server.starttls()
        server.login(GMAIL_USER, GMAIL_PASSWORD)
        server.send_message(msg)
        server.quit()

        return jsonify({"status": "Correo enviado"}), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0", port=5000)