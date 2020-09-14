import React, { useState, useEffect, useContext } from 'react'
import { UserContext } from "../../App"

const Profile = () => {
    const [data, setData] = useState([])
    const [image, setImage] = useState("")
    const {state, dispatch } = useContext(UserContext)
    useEffect(() => {
        fetch('/mypost', {
            headers: {
                "Authorization": "Bearer " + localStorage.getItem("jwt")
            }
        }).then(res => res.json())
            .then(result => {
                //console.log(result)
                setData(result.myposts)
            })
    }, [])
    useEffect(() => {
        if (image) {
            const data = new FormData()
            data.append("file", image)
            data.append("upload_preset", "insta-clone")
            data.append("cloud_name", "cnq")
            fetch("https://api.cloudinary.com/v1_1/cnq/image/upload", {
                method: "POST",
                body: data
            })
                .then(res => res.json())
                .then(data => {
                    fetch('/updateprofpic', {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": "Bearer " + localStorage.getItem("jwt")
                        },
                        body: JSON.stringify({
                            pic: data.url
                        })
                    }).then(res => res.json())
                        .then(result => {
                            localStorage.setItem("user", JSON.stringify({ ...state, image: result.pic }))
                            dispatch({ type: "UPDATEPIC", payload: result.pic })
                        })
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }, [image])
    const updatePhoto = (file) => {
        setImage(file)
    }
    return (
        <div style={{ maxWidth: "550px", margin: "0px auto" }}>
            <div style={{
                display: "flex",
                justifyContent: "space-around",
                margin: "18px 0px",
                borderBottom: "1px solid grey"
            }}>
                <div>
                    <img style={{ width: "160px", height: "160px", borderRadius: "80px" }}
                        src={state ? state.pic : "loading"}
                    />
                </div>
                <div>
                    <h4>{state ? state.name : "loading"}</h4>
                    <div style={{
                        display: "flex",
                        justifyContent: "space-between",
                        width: "110%"
                    }}>
                        <h6>{data.length} posts</h6>
                        <h6>{state? state.followers.length : "0"} followers</h6>
                        <h6>{state? state.following.length : "0"} following</h6>

                    </div>
                </div>
            </div>
            <div className="file-field input-field" style={{ margin: "10px" }}>
                <div className="btn #64b5f6 blue darken-1">
                    <span>Update Profile Pic</span>
                    <input type="file" onChange={(e) => updatePhoto(e.target.files[0])} />
                </div>
                <div className="file-path-wrapper">
                    <input className="file-path validate" type="text" />
                </div>
            </div>
            <div className="gallery">{
                data.map(item => {
                    return (
                        <img key={item._id} className="item" src={item.photo} />
                    )
                })
            }

            </div>

        </div>
    )
}


export default Profile