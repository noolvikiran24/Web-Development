import React, { useEffect, createContext, useReducer } from 'react';
import NavBar from './components/NavBar.js'
import './App.css';
import { BrowserRouter, Route, Switch, useHistory } from 'react-router-dom'

import Home from './components/screens/Home.js'
import LogIn from './components/screens/LogIn.js'
import SignUp from './components/screens/SignUp.js'
import Profile from './components/screens/Profile.js'
import CreatePost from './components/screens/CreatePost.js'
import { reducer, initialState } from './reducers/UserReducer'
import UserProfile from './components/screens/UserProfile'
import SubscribedUserPosts from './components/screens/SubscribesUserPosts'
import Reset from './components/screens/Resetpassword.js'
import NewPassword from './components/screens/Newpassword.js'
export const UserContext = createContext()

const Routing = () => {
  const history = useHistory()
  useEffect(() => {
    const user = JSON.parse(localStorage.getItem("user"))
    //console.log(user)
    if (user != null) {
      history.push('/home')
    } else {
      history.push('/login')
    }
  }, [])
  return (
    <Switch>
      <Route exact path="/home">
        <Home />
      </Route>
      <Route path="/login">
        <LogIn />
      </Route>
      <Route path="/signup">
        <SignUp />
      </Route>
      <Route path="/profile">
        <Profile />
      </Route>
      <Route path="/createpost">
        <CreatePost />
      </Route>
      <Route path="/profile/:userid">
        <UserProfile />
      </Route>
      <Route path="/myfollowingpost">
        <SubscribedUserPosts />
      </Route>
      <Route exact path="/reset">
        <Reset/>
      </Route>
      <Route path="/reset/:token">
        <NewPassword />
      </Route>
    </Switch>
  )
}
function App() {
  const [state, dispatch] = useReducer(reducer, initialState)
  return (
    <UserContext.Provider value={{ state, dispatch }}>
      <BrowserRouter>
        <NavBar />
        <Routing />
      </BrowserRouter>
    </UserContext.Provider>

  )
}

export default App;
