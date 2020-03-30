# Import Flask and initialize a Flask application
# Also imported request &  jsonify that will be used later
# Import MySQLConnection to connect to database
# Also imported Error that will be used later
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
from mysql.connector import MySQLConnection, Error
from python_mysql_dbconfig import read_db_config
 
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/order'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class Order(db.Model):
    __tablename__ = 'order'
    orderid = db.Column(db.Integer , primary_key=True)
    storeidid = db.Column(db.Integer , nullable=False)
    status = db.Column(db.String(15) , nullable =False)
    price = db.Column(db.Float(precision=2) , nullable=False)
 
    def __init__(self, orderid , storeid, status, price):
        self.orderid = orderid
        self.storeid = storeid
        self.status = status
        self.price = price
 
    def json(self):
        return {"orderid": self.orderid, "storeid": self.storeid, "status": self.status, "price": self.price}
    
@app.route("/order")
def get_all():
    return jsonify({"orders": [order.json() for order in Order.query.all()]})

@app.route("/order" , methods = ['POST'] )
def find_by_orderid():
    data = request.get_json()
    orderid= str(data['orderid'])
    if (Order.query.filter_by(orderid=orderid).first()):
        order = Order.query.filter_by(orderid=orderid).first()
        return jsonify(order.json())

    return jsonify({"message": "Order not found."}), 404

@app.route("/neworder" , methods = ['POST'] )
def add_new_order():
    data = request.get_json()
    storeid= str(data['orderid'])
    status= str(data['status'])
    price= str(data['price'])
    query = "INSERT INTO order(storeid, status, price) " \      
            "VALUES(%s,%s, %s)"
    args = (storeid, status, price)
    try:
        db_config = read_db_config()
        conn = MySQLConnection(**db_config)
 
        cursor = conn.cursor()
        cursor.execute(query, args)
    conn.commit()
    except Error as error:
        print(error)
 
    finally:
        cursor.close()
        conn.close() 

@app.route("/updateorder" , methods = ['POST'] )
def update_order():
    data = request.get_json()
    orderid= str(data['orderid'])
    status= str(date['status'])
    query= "UPDATE order SET status = status WHERE orderid = order id"\
           "VALUES(%s,%s)"
    args = (staus, orderid)
    try:
        db_config = read_db_config()
        conn = MySQLConnection(**db_config)
 
        cursor = conn.cursor()
        cursor.execute(query, args)
    conn.commit()
    except Error as error:
        print(error)
 
    finally:
        cursor.close()
        conn.close() 

if __name__ == '__main__':
    app.run()