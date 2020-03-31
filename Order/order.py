# Import Flask and initialize a Flask application
# Also imported request &  jsonify that will be used later
# Import MySQLConnection to connect to database
# Also imported Error that will be used later
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
# from mysql.connector import MySQLConnection, Error
# from python_mysql_dbconfig import read_db_config
 
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/order'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class Order(db.Model):
    __tablename__ = 'order'
    orderid = db.Column(db.Integer , primary_key=True)
    storeid = db.Column(db.Integer , nullable=False)
    cid = db.Column(db.Integer , nullable=False)
    status = db.Column(db.String(15) , nullable =False)
    price = db.Column(db.Float(precision=2) , nullable=False)
 
    def __init__(self, orderid , storeid, cid, status, price):
        self.orderid = orderid
        self.storeid = storeid
        self.cid = cid
        self.status = status
        self.price = price
 
    def json(self):
        return {"orderid": self.orderid, "storeid": self.storeid, "cid": self.cid, "status": self.status, "price": self.price}
    def jsoncid(self):
        return {"cid": self.cid}
    
#working
@app.route("/order")
def get_all():
    return jsonify({"orders": [order.json() for order in Order.query.all()]})

#working
@app.route("/order" , methods = ['POST'] )
def find_by_orderid():
    data = request.get_json()
    orderid= str(data['orderid'])
    if (Order.query.filter_by(orderid=orderid).first()):
        order = Order.query.filter_by(orderid=orderid).first()
        return jsonify(order.json())

    return jsonify({"message": "Order not found."}), 404

#working
@app.route("/order/neworder" , methods = ['POST'] )
def add_new_order():
    data = request.get_json()
    order = Order(**data)
 
    try:
        db.session.add(order)
        db.session.commit()
    except:
        return jsonify({"message": "An error occurred creating the order."}), 500
 
    return jsonify(order.json()), 201


#working
@app.route("/order/status" , methods = ['POST'] ) 
def order_by_status():
    data = request.get_json()
    status= str(data['status'])
    if (Order.query.filter_by(status=status).all()):
        orders = Order.query.filter_by(status=status).all()
        return jsonify({"orders": [order.json() for order in orders]})
    return jsonify({"message": "Order not found."}), 404

#working
@app.route("/order/customerdetails" , methods = ['POST'] )
def find_cid_by_orderid():
    data = request.get_json()
    orderid= str(data['orderid'])
    if (Order.query.filter_by(orderid=orderid).first()):
        order = Order.query.filter_by(orderid=orderid).first()
        return jsonify(order.jsoncid())

    return jsonify({"message": "Order not found."}), 404

if __name__ == '__main__':
    app.run()    