from flask import Flask, jsonify, request, redirect, url_for, render_template
from flask_cors import CORS


app = Flask(__name__)


import os
import stripe
import requests
customerURL = "http://localhost:5002/customer
ewalletURL = "http://localhost:5002/customer/getewallet"

pub_key = 'pk_test_a4WmBvNzgsdxl168Wwu0aGde00kaznh0SL'
secret_key = 'sk_test_n2Zbe1bhsIhVn7XCpYSIBSK600OHvj08YF'

stripe.api_key = secret_key

@app.route('/topup')
def topup():
    return render_template('ewallet.html', pub_key=pub_key)

@app.route('/topuppayment', methods=['POST'])
def topuppayment():
    
    customer = stripe.Customer.create(email=request.form['stripeEmail'], source=request.form['stripeToken'])

    charge = stripe.Charge.create(
        customer = customer.id,
        amount=request.form['topUpAmt'] + '00',
        currency='sgd',
        description="E-Wallet top up"
    )

    return requests.post(customerURL, json=charge)


@app.route('/successtopup')
def successtopup():
    return render_template('successtopup.html')


@app.route('/payment')
def receiveOrder():
    #check if the order contains valid JSON
    order = None
    if request.is_json():
        order = request.get_json()
    else:
        order = request.get_data()
        print("Received an invalid order:")
        print(order)
        replymessage = json.dumps({"message": "Order should be in JSON", "data": order}, default=str)
        return replymessage, 400 # Bad Request

    result = processPayment(order)

    if result['status']:
        return 200
    else:
        return 501

def processPayment(order):

    #Get the e balance amount
    ewallet = request.get(ewalletURL)

    #Get the order total amount
    orderAmount = order['total']

    #Check if the balance is enough to pay
    if ewallet < orderAmount:
        resultstatus = 501
        messagestatus = "Ewallet amount is not enough. Please top-up."

    else:
        newEwalletBalance = ewallet - orderAmount
        resultstatus = 200
        messagestatus = "Payment Successful!"

    result = {'status': resultstatus, 'message' : messagestatus}
    return result 


if __name__ == '__main__':
    app.run(port=5001,debug=True)