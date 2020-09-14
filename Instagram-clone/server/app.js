const express = require('express') 
const app = express() //invoke express
const mongoose = require('mongoose')
const PORT = 5000

const {MONGOURI} = require('./keys')

//require user model
require('./models/user.js')

//require post model
require('./models/post.js')

app.use(express.json())
//get routes
app.use(require("./routes/auth"))
app.use(require("./routes/post.js"))


mongoose.connect(MONGOURI,{
    useUnifiedTopology:true,
    useNewUrlParser: true

})
mongoose.connection.on('connected',()=>{
    console.log("connected to mongo")
    
})

mongoose.connection.on('error',(err)=>{
    console.log("Error connecting to mongo",err)
})
/*
const customMiddleWare = (req, res, next) =>{
    console.log("Middlewear executed")
    next()
}

//7GyyLGd8bgK3Z94k

app.use(customMiddleWare)

app.get('/',(req,res)=>{
    res.send("Hello World")
})
*/

app.listen(PORT,()=>{
    console.log("Server is running on ", PORT)
})