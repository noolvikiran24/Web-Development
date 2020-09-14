import React, { useState, useEffect, useContext } from 'react'
import M from 'materialize-css'
import { UserContext } from '../../App'

const Home = () => {
    const [data, setData] = useState([])
    const { state, dispatch } = useContext(UserContext)
    useEffect(() => {
        fetch('/allposts', {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + localStorage.getItem("jwt")
            }
        }).then(res => res.json())
            .then(result => {
                //console.log(result)
                setData(result.posts)
            })
    }, [])
    const likePost = (id) => {
        fetch('/like', {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("jwt")
            },
            body: JSON.stringify({
                postid: id
            })
        }).then(res => res.json())
            .then(result => {
                const newData = data.map(item => {
                    if (item._id == result._id) {
                        return result
                    } else {
                        return item
                    }
                })
                setData(newData)
            }).catch(err => {
                console.log(err)
            })

    }
    const unlikePost = (id) => {
        fetch('/unlike', {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("jwt")
            },
            body: JSON.stringify({
                postid: id
            })
        }).then(res => res.json())
            .then(result => {
                const newData = data.map(item => {
                    if (item._id == result._id) {
                        return result
                    } else {
                        return item
                    }
                })
                setData(newData)
            }).catch(err => {
                console.log(err)
            })

    }

    const makeComment = (text, postid) => {
        fetch('/comment', {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("jwt")
            },
            body: JSON.stringify({
                text: text,
                postid: postid
            })
        }).then(res => res.json())
            .then(result => {
                console.log(result)
                const newData = data.map(item => {
                    if (item._id == result._id) {
                        return result
                    } else {
                        return item
                    }
                })
                setData(newData)
            }).catch(err => {
                console.log(err)
            })
    }
    const deletePost = (postId) => {
        fetch(`deletepost/${postId}`, {
            method: "delete",
            headers: {
                "Authorization": "Bearer " + localStorage.getItem("jwt")
            }
        }).then(res => res.json())
            .then(result => {
                console.log(result)
                M.toast({ html: "Successfully deleted the post", classes: "#e53935 red darken-1" })
                const newData = data.fiter(item => {
                    return item._id !== result._id
                })
                setData(newData)
            }).catch(err => {
                console.log(err)
            })
    }
    return (
        <div className="home">
            {
                data.map(item => {
                    return (
                        <div className="card home-card" key={item._id}>
                            <h5>{item.postedBy.name}{state != null && item.postedBy._id.toString() == state._id.toString() &&
                                <i className="small material-icons" style={{ color: "black", float: "right" }}
                                    onClick={() => deletePost(item._id)}
                                >delete</i>
                            }</h5>
                            <div className="card-image">
                                <img src={item.photo} />
                            </div>
                            <div className="card-content">
                                <h6>{item.title}</h6>
                                <p>{item.body}</p>
                                <h6>{item.likes.length} likes</h6>
                                <i className="small material-icons" style={{ color: "red" }}>favorite</i>
                                {/* {item.likes.includes(state._id)
                         ?<i className="small material-icons" style={{color:"black"}}
                         onClick={()=>unlikePost(item._id)}
                         >thumb_down</i>
                         :<i className="small material-icons" style={{color:"black"}}
                         onClick={()=>likePost(item._id)} 
                         >thumb_up</i>
                        
                        } */}

                                <i className="small material-icons" style={{ color: "black" }}
                                    onClick={() => likePost(item._id)}
                                >thumb_up</i>
                                <i className="small material-icons" style={{ color: "black" }}
                                    onClick={() => unlikePost(item._id)}
                                >thumb_down</i>

                                {
                                    item.comments.map(record => {
                                        return (

                                            <h6 key={record._id}><span style={{ fontWeight: "500" }}>{record.postedBy.name}:</span>{record.text}</h6>
                                        )
                                    })
                                }
                                <form onSubmit={(e) => {
                                    e.preventDefault()
                                    makeComment(e.target[0].value, item._id)
                                    console.log(e.target[0].value)
                                }}>
                                    <input
                                        type="text"
                                        placeholder="Comment"
                                    />

                                </form>

                            </div>

                        </div>
                    )
                })
            }

        </div>
    )
}


export default Home