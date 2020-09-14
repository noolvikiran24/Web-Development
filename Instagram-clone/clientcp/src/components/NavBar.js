import React, {useRef, useContext, useEffect, useState} from 'react'
import { UserContext } from '../App'
import M from 'materialize-css'

//replace a tags with Link so that the screen does not refresh when clicked
import { Link, useHistory } from 'react-router-dom'
const NavBar = () => {
    const { state, dispatch } = useContext(UserContext)
    const  searchModal = useRef(null)
    const [search,setSearch] = useState('')
    const [userDetails,setUserDetails] = useState([])
    const history = useHistory()
    useEffect(()=>{
        M.Modal.init(searchModal.current)
    },[])
    const renderList = () => {
        //console.log(state)
        if (state) {
            return [
                <li><Link to="/profile">My Profile</Link></li>,
                <li><Link to="/createpost">Create Post</Link></li>,
                <li>
                    <button className="btn #90caf9 blue lighten-3" type="submit" name="action" onClick={
                        () => {
                            localStorage.clear()
                            dispatch({ type: "CLEAR" })
                            M.toast({ html: "You were logged out", classes: "#e53935 red darken-1" })
                            history.push('/login')

                        }
                    } >
                        Log Out
                </button>


                </li>
            ]
        } else {
            return [
                <li><Link to="/login">Log In</Link></li>,
                <li><Link to="/signup">Sign Up</Link></li>
            ]
        }

    }

    const fetchUsers = (query) => {
        setSearch(query)
        fetch('/searchusers', {
            method: "post",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                query
            })
        }).then(res => res.json())
            .then(results => {
                setUserDetails(results.user)
            })
    }

    return (
        <nav>
            <div className="nav-wrapper white" key="1">
                <Link to={state ? "/home" : "/login"} className="brand-logo left">Instagram</Link>
                <ul id="nav-mobile" className="right">
                    {renderList()}
                </ul>
            </div>
            <div id="modal1" class="modal" ref={searchModal} style={{ color: "black" }}>
                <div className="modal-content">
                    <input
                        type="text"
                        placeholder="search users"
                        value={search}
                        onChange={(e) => fetchUsers(e.target.value)}
                    />
                    <ul className="collection">
                        {userDetails.map(item => {
                            return <Link to={item._id !== state._id ? "/profile/" + item._id : '/profile'} onClick={() => {
                                M.Modal.getInstance(searchModal.current).close()
                                setSearch('')
                            }}><li className="collection-item">{item.email}</li></Link>
                        })}

                    </ul>
                </div>
                <div className="modal-footer">
                    <button className="modal-close waves-effect waves-green btn-flat" onClick={() => setSearch('')}>close</button>
                </div>
            </div>
        </nav>
    )
}

export default NavBar