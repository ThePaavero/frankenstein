const express = require('express')
const app = express()
const axios = require('axios')

const getCars = () => {
  return new Promise((resolve, reject) => {
    axios.get('http://frankenstein-demo.dev:8000/?json=get_posts&post_type=cars')
      .then((response) => {
        resolve(response.data)
      })
      .catch((err) => {
        reject(err)
      })
  })
}

app.get('/cars', function (req, res) {
  getCars()
    .then((data) => {
      res.send(data)
    })
    .catch((err) => {
      res.send(err)
    })
})

const port = 3000
app.listen(port, function () {
  console.log('Frankenstein Express example running @ localhost:' + port)
})
