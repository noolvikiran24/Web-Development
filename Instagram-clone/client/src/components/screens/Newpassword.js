import React,{useState,} from 'react'
import {useHistory,useParams} from 'react-router-dom'
import M from 'materialize-css'

const newPassword = ()=>{
    const history = useHistory()
    const [password, setPassword] = useState("")
    const {token} = useParams()

    const postData = ()=>{
        fetch("/newpassword",{
            method:"POST",
            headers:{
                "Content-Type":"application/json"
            },
            body:JSON.stringify({
                password:password,
                token:token
            })
        }).then(res=>res.json())
        .then(data=>{
            if(data.error){
                M.toast({html: data.error,classes:"#c62828 red darken-3"})
            }else{
                M.toast({html:data.message,classes:"#43a047 green darken-1"})
                history.push('/login')
            }
        }).catch(error=>{
            console.log(error)
        })
    }

    return(
        <div className="mycard">
            <div className="card auth-card input-field">
                <h2>Instagram</h2>

                <input
                type="password"
                placeholder="Enter a new password"
                value={password}
                onChange={(e)=>setPassword(e.target.value)}
                />
                <button className="btn waves-effect waves-light #64b5f6 blue darken-1"
                onClick={()=>postData()}
                >
                    Update password
                </button>
            </div>
        </div>
    )

}

export default newPassword