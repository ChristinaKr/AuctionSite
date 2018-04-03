import React from 'react';

import {Navbar, NavItem, MenuItem, NavDropdown, Nav} from 'react-bootstrap';

class CustomNav extends React.Component {

  render() {
    return <div>
      <Navbar>
        <Navbar.Header>
          <Navbar.Brand>
            <a href="/">React-Bootstrap</a>
          </Navbar.Brand>
        </Navbar.Header>
        <Nav>
          <NavItem eventKey={1} href="/profile">
            Profile
          </NavItem>
          <NavItem eventKey={2} href="/auction">
            Auction
          </NavItem>
          <NavDropdown eventKey={3} title="Dropdown" id="basic-nav-dropdown">
            <MenuItem eventKey={3.1}>Action</MenuItem>
            <MenuItem eventKey={3.2}>Another action</MenuItem>
            <MenuItem eventKey={3.3}>Something else here</MenuItem>
            <MenuItem divider />
            <MenuItem eventKey={3.4}>Separated link</MenuItem>
          </NavDropdown>
        </Nav>
      </Navbar>
    </div>;
  }
}

export default CustomNav;
