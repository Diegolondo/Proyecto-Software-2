from locust import HttpUser, task, between

class GatewayUser(HttpUser):
    wait_time = between(1, 3)
    host = "http://127.0.0.1:8000"  # Gateway Laravel

    token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzYwMTQ4Mjg0LCJleHAiOjE3NjAxNTE4ODQsIm5iZiI6MTc2MDE0ODI4NCwianRpIjoiRTNMbzZickUzRVJvS3d5cyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.Z8QsU7nYAa9CRtStAksJHIX7UKuEhooLNloJkdWrQq8"  # 👈 reemplaza con tu token actual

    headers = {
        "Authorization": f"Bearer {token}",
        "Content-Type": "application/json"
    }

    @task(1)
    def login(self):
        """Simula un inicio de sesión"""
        self.client.post("/api/login", json={
            "email": "CrisArenas@unal.edu.co",
            "password": "1234"
        })

    @task(2)
    def get_products(self):
        """Consulta productos desde el gateway"""
        self.client.get("/api/products", headers=self.headers)

    @task(1)
    def get_users(self):
        """Consulta usuarios"""
        self.client.get("/api/users", headers=self.headers)

    @task(1)
    def get_reports(self):
        """Consulta reportes"""
        self.client.get("/api/reports", headers=self.headers)
