import React, {useState, useEffect} from 'react'
import {Link,useHistory} from 'react-router-dom'
import M from 'materialize-css'

const CreatePost = () =>{
    const history = useHistory()
    const [title,setTitle] = useState("")
    const [description, setDescription] = useState("")
    const [image, setImage] = useState("")
    const [url, setUrl] = useState("")
    
    useEffect(()=>{
        if(url){
            fetch("/createpost", {
                method: "POST",
                headers: {
                    "Content-Type":"application/json",
                    "Authorization": "Bearer "+localStorage.getItem("jwt")
                },
                body:JSON.stringify({
                    title: title,
                    body: description,
                    picUrl: url
                })
            }).then(res=>res.json())
            .then(data=>{
                if(data.error){
                    M.toast({html: data.error, classes:"#c62828 red darken-3"})
                }else{
                    M.toast({html: "Created post successfully", classes:"#43a047 green darken-1"})
                    history.push('/')
                }
            }).catch(error=>{
                console.log(error)
            })
        }
    }, [url])

    const postDetails = ()=>{
        const data = new FormData()
        data.append("file",image)
        data.append("upload_preset","InstaCloud")
        data.append("cloud_name","imagecloudkiran")
        fetch("https://api.cloudinary.com/v1_1/imagecloudkiran/image/upload",{
            method: "post",
            body: data
        }).then(res=>res.json())
        .then(data=>{  
            setUrl(data.url) 
            // ph =  data.url
        })
        // .then((text)=>{ // We can also use useEffect instead
        //     //console.log(text)
        //     fetch("/createpost",{
        //         method:"post",
        //         headers:{
        //             "Content-Type":"application/json",
        //             "Authorization":"Bearer "+localStorage.getItem("jwt")
        //         },
        //         body:JSON.stringify({
        //             title:title,
        //             body:description,
        //             picUrl:text
        //         })
        //     }).then(res=>res.json())
        //     .then(data=>{
        //         if(data.error){
        //             M.toast({html: data.error,classes:"#e53935 red darken-1"})
        //         }else{
        //             M.toast({html: "Successfully created the post",classes:"#4caf50 green"})
        //             history.push('/createpost')
        //         }
        //     }).catch(err=>{
        //         console.log(err)
        //     })
        // })
        .catch(err=>{
            console.log(err)
        })     
    }
    return(
        <div className ="card input-file">
            <input type="text" placeholder="Title"
            value = {title}
            onChange = {(e)=>setTitle(e.target.value)}
            
            />
            <input type="text" placeholder="Description"
            value = {description}
            onChange = {(e)=>setDescription(e.target.value)}
            />
            <div className="file-field input-field">
                <div className="btn #90caf9 blue lighten-3">
                    <span>Uplaod Image</span>
                    <input type="file"
                    onChange = {(e)=>setImage(e.target.files[0])}
                    />
                </div>
                <div className="file-path-wrapper">
                    <input className="file-path validate" type="text"/> 
                </div>
            </div>
            <button className="btn #90caf9 blue lighten-3" type="submit" name="action"
            onClick ={()=>postDetails()}>
                Submit Post
            </button>
        </div>
    )
}

export default CreatePost