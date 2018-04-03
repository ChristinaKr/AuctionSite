import React from 'react';

import {Panel} from 'react-bootstrap';

export default class CustomPanel extends React.Component {

    render() {
        return <div>
            <Panel>
                <Panel.Heading>{this.props.heading}</Panel.Heading>
                <Panel.Body>{this.props.content}</Panel.Body>
            </Panel>
        </div>;
    }
}
