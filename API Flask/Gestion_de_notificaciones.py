from flask import Flask, request, jsonify
import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

app = Flask(__name__)

API_KEY = "1234"

GMAIL_USER = "diegolohi2@gmail.com"
GMAIL_PASSWORD = "tezxtubcgvbzfgjc"

DESTINATARIO = "dilondonoo@unal.edu.co"
ASUNTO = "Nuevo producto registrado en el sistema"

@app.before_request
def verificar_api_key():
    api_key_recibida = request.headers.get("X-API-Key")
    if api_key_recibida != API_KEY:
        return jsonify({"message": "Acceso Denegado"}), 403

@app.route('/send-email', methods=['POST'])
def send_email():
    try:
        data = request.json
        # Redactar el mensaje con los atributos del producto
        mensaje = (
            f"Se ha registrado un nuevo producto en el sistema.\n\n"
            f"Detalles del producto:\n"
            f"- Nombre: {data.get('nombre')}\n"
            f"- Precio: {data.get('precio')}\n"
            f"- Cantidad: {data.get('cantidad')}\n\n"
            f"Este mensaje fue generado automáticamente."
        )

        # Crear el correo
        msg = MIMEMultipart()
        msg['From'] = GMAIL_USER
        msg['To'] = DESTINATARIO
        msg['Subject'] = ASUNTO
        msg.attach(MIMEText(mensaje, 'plain'))

        # Enviar correo
        with smtplib.SMTP('smtp.gmail.com', 587) as server:
            server.starttls()
            server.login(GMAIL_USER, GMAIL_PASSWORD)
            server.send_message(msg)

        return jsonify({"status": "Correo enviado"}), 200

    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    app.run(debug=True, host="0.0.0.0", port=5000)