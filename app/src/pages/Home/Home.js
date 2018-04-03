import React from 'react';

import CustomPanel from '../../components/custom-panel/custom-panel';

export default class HomePage extends React.Component {

    render() {
        return <div>
            <CustomPanel heading="The heading of the home page panel" body="the body"></CustomPanel>
        </div>;
    }
}
