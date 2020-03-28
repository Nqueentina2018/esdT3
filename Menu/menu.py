# Import Flask and initialize a Flask application
# Also imported request &  jsonify that will be used later
from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
 
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+mysqlconnector://root@localhost:3306/menu'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
 
db = SQLAlchemy(app)
CORS(app)

class Menu(db.Model):
    __tablename__ = 'Menu'
 
    menuID = db.Column(db.String(13), primary_key=True)
    name = db.Column(db.String(64), nullable=False)
    price = db.Column(db.Float(precision=2), nullable=False)
    category = db.Column(db.String(15) , nullable =False)
    
 
    def __init__(self, menuID, name, price):
        self.menuID = menuID
        self.name = name
        self.price = price
        self.category = category
       
 
    def json(self):
        return {"menuID": self.menuID, "name": self.name, "price": self.price, "category":self.category}
 
 
@app.route("/menu")
def get_all():
    return jsonify({"menu": [menu.json() for menu in Menu.query.all()]})
 
 
@app.route("/menu/<string:category>")
def get_all_by_category(category):
    return jsonify({"menu": [menu.json() for menu in Menu.query.filter_by(category=category).all()]})


 

 
if __name__ == '__main__':
    app.run(port=5000, debug=True)