import React from 'react';
import ReactDOM from 'react-dom';

function User() {
    return (
        <div className="container mt-5">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card text-center">
                        <div className="card-header"><h2>REACT FRONTEND FOR HOUSING STREET</h2></div>

                        <div className="card-body">Test for Frontend!!</div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default User;

// DOM element
if (document.getElementById('user')) {
    ReactDOM.render(<User />, document.getElementById('user'));
}
