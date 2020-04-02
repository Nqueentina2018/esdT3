from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
app = Flask(__name__)

app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/customer'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
CORS(app)

class Customer(db.Model):
    __tablename__ = 'customer'
    cid = db.Column(db.Integer , primary_key=True)
    name = db.Column(db.String(15) , nullable =False)
    phone = db.Column(db.String(10) , nullable = False)
    username = db.Column(db.String(30) , nullable =False)
    password = db.Column(db.String(30) , nullable = False)
    ewallet = db.Column(db.Float(precision=2))
 
    def __init__(self, cid , name , phone , ewallet ):
        self.cid = cid
        self.name = name
        self.phone = phone
        self.ewallet = ewallet
 
    def json(self):
        return {"id": self.cid, "name": self.name, "phone": self.phone, "ewallet": self.ewallet }
    def jsonewallet(self):
        return {"ewallet": self.ewallet}

@app.route("/customer")
def get_all():
    return jsonify({"customers": [customer.json() for customer in Customer.query.all()]})


@app.route("/customer" , methods = ['POST'] )
def find_by_cid():
    data = request.get_json()
    cid= str(data['cid'])
    if (Customer.query.filter_by(cid=cid).first()):
        customer = Customer.query.filter_by(cid=cid).first()
        return jsonify(customer.json())

    return jsonify({"message": "Customer not found."}), 404

@app.route("/customer/getewallet" , methods=['POST'])
def ewallet_by_cid():
    data = request.get_json()
    cid= str(data['cid'])
    if (Customer.query.filter_by(cid=cid).first()):
        customer = Customer.query.filter_by(cid=cid).first()
        return jsonify(customer.jsonewallet())

    return jsonify({"message": "Customer not found."}), 404

@app.route("/customer/updatewallet" , methods=['POST'])
def update_wallet():
    data = request.get_json()
    cid= str(data['cid'])
    newEwalletBalance = str(data['newEwalletBalance'])
    if (Customer.query.filter_by(cid=cid).first()):
        customer = Customer.query.filter_by(cid=cid).first()
        print(newEwalletBalance)
        customer.ewallet = newEwalletBalance
        db.session.commit()
        return jsonify({"message": "Ewallet updated"}) 

    return jsonify({"message": "Customer not found."}), 404

if __name__ == '__main__':
    app.run(port=5000)