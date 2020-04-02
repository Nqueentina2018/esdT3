from flask import Flask, jsonify, request, redirect, url_for, render_template
from flask_cors import CORS


app = Flask(__name__)


import os
import stripe
import requests
import json

updateEwalletURL = "http://localhost/customer/updatewallet"
newOrderURL = "http://localhost/order/neworder"

pub_key = 'pk_test_a4WmBvNzgsdxl168Wwu0aGde00kaznh0SL'
secret_key = 'sk_test_n2Zbe1bhsIhVn7XCpYSIBSK600OHvj08YF'

stripe.api_key = secret_key

@app.route('/topup')
def topup():
    return render_template('ewallet.html', pub_key=pub_key)

@app.route('/topuppayment', methods=['POST'])
def topuppayment():
    
    #Check contains valid JSON. UI should send customer ID and the current E wallet Balance
    if request.get_json():
        customerDetailsfromUI = request.get_json()
    else:
        customerDetailsfromUI = request.get_data()
        print("Received an invalid order:")
        print(customerDetailsfromUI)
        replymessage = json.dumps({"message": "Order should be in JSON", "data": customerDetailsfromUI}, default=str)
        return replymessage, 400 # Bad Request

    #Strip payment process. 
    #1. Create the customer
    #2. Create the charge - payment process is done here
    customer = stripe.Customer.create(email=request.form['stripeEmail'], source=request.form['stripeToken'])

    charge = stripe.Charge.create(
        customer = customer.id,
        amount = int(request.form['topUpAmt']) * 100,
        currency='sgd',
        description="E-Wallet top up"
    )
    
    #Successful payment process 
    #1. Retrive customer id and ewallet balance
    #2. Retrive topup amount from charge
    cid = customerDetailsfromUI['cid']
    currentEwalletBalance = customerDetailsfromUI['eWallet']     
    topupAmt = charge['amount']/100

    #Add the topup amount to current ewallet balance
    newEwalletBalance = currentEwalletBalance + topupAmt

    customerObject = {
                        "cid": cid, 
                        "newEwalletBalance" : newEwalletBalance
                    }
    
    requests.post(updateEwalletURL, json = customerObject)
    resultstatus = 200
    messagestatus = "Top-up Successful!"    

    result = {'status': resultstatus, 'message' : messagestatus, 'object' : customerObject}
    return result


@app.route('/payment', methods=['POST'])
def receiveOrder():
    #check if the order contains valid JSON

    payment = None
    if request.get_json():
        payment = request.get_json()
    else:
        payment = request.get_data()
        print("Received an invalid order:")
        print(payment)
        replymessage = json.dumps({"message": "Order should be in JSON", "data": payment}, default=str)
        return replymessage, 400 # Bad Request

    result = processPayment(payment)

    if result['status'] == 200:
        return result['message'] , result['object']
    else:
        return result['message']

def processPayment(payment):

    #UI is sending sending storeid, ewallet balance, order amount and customer id
    cid = payment['cid']
    orderAmount = payment['totalAmt']
    ewalletBalance = payment['eWallet']
    sid = payment['sid']
    
    #Check if the balance is enough to pay
    if ewalletBalance < orderAmount:
        resultstatus = 501
        messagestatus = "Insufficient E-Wallet Balance! Please top-up."

    else:
        newEwalletBalance = ewalletBalance - orderAmount        
        customerObject = {
                        "cid": cid, 
                        "newEwalletBalance" : newEwalletBalance,
                        "storeid": sid,
                        "price": orderAmount,
                        "status" : "confirmed" 
                        }
        # customerObject = json.dumps(customerObject) , dumps makes it into json string so try not to use
        requests.post(updateEwalletURL, json = customerObject)
        requests.post(newOrderURL, json = customerObject)
        resultstatus = 200
        messagestatus = "Payment Successful!"

    result = {'status': resultstatus, 'message' : messagestatus, 'object' : customerObject}
    return result 


if __name__ == '__main__':
    app.run(debug=True, port=5003)