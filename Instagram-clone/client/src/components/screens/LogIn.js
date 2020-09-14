import React,{useState, useContext} from 'react'
import {Link, useHistory} from 'react-router-dom'
import M from 'materialize-css'

import {UserContext} from '../../App'
const Login = ()=>{
    const {state,dispatch} = useContext(UserContext)
    const history = useHistory()
    const [email, setEmail] = useState("")
    const [password, setPassword] = useState("")
    const postLoginData = ()=>{
        //console.log("came here")
        if(!/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/.test(email)){
            M.toast({html: "Please enter a valid email id",classes:"#e53935 red darken-1"})
            return
        }
        fetch("/login",{
            method: "post",
            headers:{
               "Content-Type":"application/json"
            },
            body: JSON.stringify({
                email:email,
                password:password

            })
        }).then(res=>res.json())
        .then(data=>{
            //console.log(data)
            if(data.error){
                M.toast({html: data.error,classes:"#e53935 red darken-1"})
            }else{
                localStorage.setItem("jwt",data.token)
                localStorage.setItem("user", JSON.stringify(data.user))
                dispatch({type:"USER",payload:data.user})
                M.toast({html: "Logging you in",classes:"#4caf50 green"})
                history.push('/home')
            }
        }).catch(err=>{
            console.log(err)
        })
    }
    return(
       <div className="my-card">
            <div className="card auth-card input-field">
                <h2>Instagram</h2>
                <input 
                    type = "text"
                    placeholder = "Email Id"
                    value = {email}
                    onChange={(e)=>setEmail(e.target.value)}
                />
                <input
                    type = "password"
                    placeholder = "Password"
                    value = {password}
                    onChange = {(e)=>setPassword(e.target.value)}
                />
                <button className="btn #90caf9 blue lighten-3" type="submit" name="action" onClick={()=>postLoginData()}>
                    Log In
                </button>
                <p>
                    <Link to="/signup">
                        Do not have an account? Sign up
                    </Link>
                 </p>
                 <p>
                    <Link to="/resetpassword">
                        Forgot password?
                    </Link>
                 </p>
            </div>
       </div>
    )
}

export default Login