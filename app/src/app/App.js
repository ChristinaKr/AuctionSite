import React, {Component} from 'react';
import {BrowserRouter, Route, Redirect, Switch} from 'react-router-dom';
import {Grid, Row} from 'react-bootstrap';
import './App.css';

import CustomNavbar from '../components/custom-navbar/custom-navbar';
import LoginPage from '../pages/Login/login';
import HomePage from "../pages/Home/Home";
import AuctionPage from "../pages/Auction/auction";
import ProfilePage from "../pages/Profile/Profile";

export default class App extends Component {
    render() {
        return (
            <div className="App">
                <BrowserRouter>
                    <PrimaryLayout />
                </BrowserRouter>
            </div>
        );
    }
}

const PrimaryLayout = () => (
    <div className="primary-layout">
        <header>
            <CustomNavbar></CustomNavbar>
        </header>
        <main>
            <Grid>
                {/*<Row xs={12} md={8} lg={6}>*/}
                    <Switch>
                        <Route path="/" exact component={HomePage}/>
                        <Route path="/auction" component={AuctionPage}/>
                        <PrivateRoute path="/profile" component={ProfilePage}/>
                        <Route path="/login" component={LoginPage}/>
                        <Redirect to="/404"/>
                    </Switch>
                {/*</Row>*/}
            </Grid>
        </main>
    </div>
)

const auth = {
    isAuthenticated: false,
}

// https://reacttraining.com/react-router/web/example/auth-workflow
const PrivateRoute = ({component: Component, ...rest}) => (
    <Route {...rest} render={props => (
        auth.isAuthenticated ? (
                <Component {...props}/>
            ) : (
                <Redirect to={{
                    pathname: '/login',
                    state: {from: props.location}
                }}/>
            )
    )}/>
)
