from flask import Flask, jsonify, request, redirect, url_for, render_template
from flask_cors import CORS, cross_origin


app = Flask(__name__)
CORS(app)

import os
import stripe
import requests
import json

updateEwalletURL = "http://localhost:5000/customer/updatewallet"
getEwalletUrl = "http://localhost:5000/customer/getewallet"
newOrderURL = "http://localhost:5002/order/neworder"
genIdURL = "http://localhost:5002/order/gen_id"

pub_key = 'pk_test_a4WmBvNzgsdxl168Wwu0aGde00kaznh0SL'
secret_key = 'sk_test_n2Zbe1bhsIhVn7XCpYSIBSK600OHvj08YF'

stripe.api_key = secret_key

@app.route('/topup')
def topup():
    return render_template('ewallet.html', pub_key=pub_key)

@app.route('/topuppayment', methods=['POST'])
def topuppayment():
    
    #Check contains valid JSON. UI should send customer ID and the current E wallet Balance
    # if request.get_json():
    #     customerDetailsfromUI = request.get_json()
    # else:
    #     customerDetailsfromUI = request.get_data()
    #     print("Received an invalid order:")
    #     print(customerDetailsfromUI)
    #     replymessage = json.dumps({"message": "Order should be in JSON", "data": customerDetailsfromUI}, default=str)
    #     return replymessage, 400 # Bad Request

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
# @cross_origin
# def application(environ, start_response):
#   if environ['REQUEST_METHOD'] == 'OPTIONS':
#     start_response(
#       '200 OK',
#       [
#         ('Content-Type', 'application/json'),
#         ('Access-Control-Allow-Origin', '*'),
#         ('Access-Control-Allow-Headers', 'Authorization, Content-Type'),
#         ('Access-Control-Allow-Methods', 'POST'),
#       ]
#     )
#     return ''

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
    # get ewallet balance from cid
    cid = int(payment['cid'])
    orderAmount = float(payment['totalAmt'])

    response=requests.post(getEwalletUrl, json = {'cid' : cid})
    data = response.json()
    ewalletBalance = float(data['ewallet'])

    response1=requests.get(genIdURL)
    data1 = response1.json()
    orderid = int(data1['orderid'])

    #Check if the balance is enough to pay
    if float(ewalletBalance) < float(orderAmount):
        resultstatus = 501
        messagestatus = "Insufficient E-Wallet Balance! Please top-up."

    else:
        newEwalletBalance = float(ewalletBalance) - float(orderAmount)
        customerObject = {
                        "cid": cid, 
                        "newEwalletBalance" : newEwalletBalance,
                        "price": orderAmount
                        }
        orderObject = {
                        "orderid" : orderid,
                        "cid": cid, 
                        "price": orderAmount,
                        "status" : "Confirmed" 
                        }
        # customerObject = json.dumps(customerObject) , dumps makes it into json string so try not to use
        requests.post(updateEwalletURL, json = customerObject)
        requests.post(newOrderURL, json = orderObject)
        resultstatus = 200
        messagestatus = "Payment Successful!"

    result = {'status': resultstatus, 'message' : messagestatus, 'object' : customerObject}
    return result 


if __name__ == '__main__':
    app.run(debug=True, port=5003)