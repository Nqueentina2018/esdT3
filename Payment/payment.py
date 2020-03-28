from flask import Flask, jsonify, request, redirect, url_for, render_template
from flask_cors import CORS


app = Flask(__name__)


import os
import stripe
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

    return redirect(url_for('successtopup'))

@app.route('/successtopup')
def successtopup():
    return render_template('successtopup.html')

if __name__ == '__main__':
    app.run(port=5001,debug=True)