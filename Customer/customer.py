from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from os import environ
app = Flask(__name__)

# connect this file to wamp
# root@localhost:3306/book is to login and refering to specific database
# root:abc -> username:password
app.config['SQLALCHEMY_DATABASE_URI'] = environ.get('dbURL')
# 'mysql+mysqlconnector://root@localhost:3306/book'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)

class Customer(db.Model):
    __tablename__ = 'customer'
 
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(15), nullable=False)
    phone = db.Column(db.String(10), nullable=False)
    wallet = db.Column(db.Double(Precision=2))
 
    def __init__(self, id , name , phone , wallet):
        self.id = id
        self.name = name
        self.phone = phone
        self.wallet = wallet
 
    def json(self):
        return {"id": self.id, "name": self.name, "phone": self.phone, "wallet": self.wallet}

@app.route("/customer")
def get_all():
    return jsonify({"customer": [customer.json() for book in Customer.query.all()]})