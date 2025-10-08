from locust import HttpUser, task, between

class GatewayUser(HttpUser):
    wait_time = between(1, 3)
    host = "http://127.0.0.1:8000"  # Gateway Laravel

    # 🔑 Token JWT obtenido al hacer login
    token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzU5NzEzNjU5LCJleHAiOjE3NTk3MTcyNTksIm5iZiI6MTc1OTcxMzY1OSwianRpIjoiRkZnTm1rV2FMdXNPRjlpRyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.a9YIt4SLG8X0MNPApWN6lQgFoIb-Upyt9kWuRcwf_Cg"

    # 🧠 Encabezados con token de autorización
    headers = {
        "Authorization": f"Bearer {token}",
        "Content-Type": "application/json"
    }

    @task(1)
    def login(self):
        """Simula el login normal"""
        self.client.post("/api/login", json={
            "email": "CrisArenas@unal.edu.co",
            "password": "1234"
        })

    @task(2)
    def get_products(self):
        """Consulta los productos"""
        self.client.get("/api/products", headers=self.headers)

    @task(1)
    def get_users(self):
        """Consulta los usuarios"""
        self.client.get("/api/users", headers=self.headers)

    @task(1)
    def get_reports(self):
        """Consulta los reportes"""
        self.client.get("/api/reports", headers=self.headers)
