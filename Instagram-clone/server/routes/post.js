const express = require("express")
const router = express.Router()
const mongoose = require("mongoose")
const Post = mongoose.model("Post")
const requireLogin = require('../middleware/requireLogin')


//get all posts
router.get('/allposts',requireLogin,(req,res)=>{
    Post.find()
    .populate("postedBy","_id name")
    .populate("comments.postedBy","_id name")
    .then(posts=>{
        res.json({posts:posts})
    })
    .catch(err=>{
        console.log(err)
    })
})
router.get('/mypost',requireLogin,(req,res)=>{
    Post.find({postedBy:req.user._id})
    .populate("postedBy","_id name")
    .then(myposts=>{
        res.json({myposts:myposts})
    })
    .catch(err=>{
        console.log(err)
    })
})

router.post('/createpost',requireLogin,(req,res)=>{
    const {title,body,picUrl} = req.body
    console.log(title,body,picUrl)
    if(!title || !body || !picUrl){
        return res.status(422).json({error:"Please enter all the required fields"})
    }

    //console.log(req.user)

    req.user.password = undefined
    const post = new Post({
        title:title,
        body:body,
        photo:picUrl,
        postedBy:req.user
     })

     post.save()
     .then(result=>{
         res.json({post:result})
     })
     .catch(err=>{
         console.log(err)
     })
})


router.put('/like',requireLogin,(req,res)=>{
    Post.findByIdAndUpdate(req.body.postid,{
        $push:{likes:req.user._id}
    },{
        new:true
    }).exec((err,result)=>{
        if(err){
            return res.status(422).json({error:err})
        }

        res.json(result)

    })
})
router.put('/unlike',requireLogin,(req,res)=>{
    Post.findByIdAndUpdate(req.body.postid,{
        $pull:{likes:req.user._id}
    },{
        new:true
    }).exec((err,result)=>{
        if(err){
            return res.status(422).json({error:err})
        }

        res.json(result)

    })
})

router.put('/comment',requireLogin,(req,res)=>{
    const comment = {
        text: req.body.text,
        postedBy:req.user._id
    }
    Post.findByIdAndUpdate(req.body.postid,{
        $push:{comments:comment}
    },{
        new:true
    })
    .populate("comments.postedBy","_id name")
    .populate("postedBy", "_id name")
    .exec((err,result)=>{
        if(err){
            return res.status(422).json({error:err})
        }

        res.json(result)

    })
})


router.delete('/deletepost/:postId',requireLogin, (req,res)=>{
    Post.findOne({_id:req.params.postId})
    .populate("postedBy", "_id")
    .exec((err,post)=>{
        if(err || !post){
            req.status(422).json({error:err})
        }
        if(post.postedBy._id.toString()===req.user._id.toString()){ //if user logged is the user deleting the post, convert to string as user and postedBy are objects
            post.remove()
            .then(result=>{
                res.json(result)
            }).catch(err=>{
                console.log(err)
            })
        }
    })
})

router.get('/getsubpost',requireLogin,(req,res)=>{

    // if postedBy in following
    Post.find({postedBy:{$in:req.user.following}})
    .populate("postedBy","_id name")
    .populate("comments.postedBy","_id name")
    .sort('-createdAt')
    .then(posts=>{
        res.json({posts})
    })
    .catch(err=>{
        console.log(err)
    })
})

module.exports = router