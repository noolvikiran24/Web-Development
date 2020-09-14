const express = require('express')
const router = express.Router()
const mongoose = require('mongoose')
const User = mongoose.model('User')
const bcryptjs = require('bcryptjs')
const jwt = require('jsonwebtoken')
const {JWT_SECRET} = require('../keys')



// router.get('/protected',requireLogin,(req,res)=>{
//     res.send("Hello")
// })
//Signup a new user
router.post('/signup',(req,res)=>{
   // console.log(req.body.name)

   const {name, email, password} = req.body
   if(!name || !email || !password){
      return res.status(422).json({error: "Please enter all the required fields"})
   }

   User.findOne({email:email})
   .then(existingUser=>{
       if(existingUser){
            return res.json({error:"An user with the entered email id already exists"})
       }

       bcryptjs.hash(password,12)
       .then(hashedPassword=>{
           const newUser = new User({
               name: name,
               email: email,
               password: hashedPassword
           })
           newUser.save()
           .then(user=>{
               res.json({message:  "Registered the user successfully"})
           })
           .catch(err=>{
               console.log(err)
           })
       })
   })
   .catch(err=>{
       console.log(err)
   })
   //res.json({message:"Registration successfull, please login"})
})

//Signin as an existing user
router.post('/login',(req,res)=>{
    const {email, password} = req.body

    if(!email || !password){
        return res.status(422).json({"error": "Please enter all the required fields"})
    }

    User.findOne({email:email})
    .then(validUser=>{
        if(!validUser){
            return res.status(422).json({error: "Invalid email id or password"})
        }
        bcryptjs.compare(password, validUser.password)
        .then(correctPassword=>{
            if(correctPassword){
                //res.json({message: "Login successful"})
                const token = jwt.sign({_id:validUser._id}, JWT_SECRET)
                const {_id,name,email} = validUser
                res.json({token:token,user:{_id,name,email}})
            }else{
                return res.json({error: "Wrong password. Try again or reset the password"})
            }
        })
        .catch(err=>{
            console.log(err)
        })
    })
})

router.post('/newpassword',(req,res)=>{
    const newPassword = req.body.password
    const sentToken = req.body.token
    User.findOne({resetToken:sentToken,expireToken:{$gt:Date.now()}})
    .then(user=>{
        if(!user){
            return res.status(422).json({error:"Try again session expired"})
        }
        bcrypt.hash(newPassword,12).then(hashedpassword=>{
           user.password = hashedpassword
           user.resetToken = undefined
           user.expireToken = undefined
           user.save().then((saveduser)=>{
               res.json({message:"password updated success"})
           })
        })
    }).catch(err=>{
        console.log(err)
    })
})

module.exports = router