if (process.env.NODE_ENV !== 'production') {
    require('dotenv').load()
  }
  
  const paypalSecretKey = process.env.PAYPAL_SECRET_KEY
  const paypalPublicKey = process.env.PAYPAL_PUBLIC_KEY
  
  const express = require('express')
  const app = express()
  const fs = require('fs')
  const paypal = require('paypal')(paypalSecretKey)
  
  app.set('view engine', 'ejs')
  app.use(express.json())
  app.use(express.static('public'))
  
  app.get('/store', function(req, res) {
    fs.readFile('items.json', function(error, data) {
      if (error) {
        res.status(500).end()
      } else {
        res.render('store.ejs', {
          paypalPublicKey: paypalPublicKey,
          items: JSON.parse(data)
        })
      }
    })
  })
  
  app.post('/purchase', function(req, res) {
    fs.readFile('items.json', function(error, data) {
      if (error) {
        res.status(500).end()
      } else {
        const itemsJson = JSON.parse(data)
        const itemsArray = itemsJson.music.concat(itemsJson.merch)
        let total = 0
        req.body.items.forEach(function(item) {
          const itemJson = itemsArray.find(function(i) {
            return i.id == item.id
          })
          total = total + itemJson.price * item.quantity
        })
  
        paypal.charges.create({
          amount: total,
          source: req.body.paypalTokenId,
          currency: 'usd'
        }).then(function() {
          console.log('Charge Successful')
          res.json({ message: 'Successfully purchased items' })
        }).catch(function() {
          console.log('Charge Fail')
          res.status(500).end()
        })
      }
    })
  })
  
  app.listen(3000)