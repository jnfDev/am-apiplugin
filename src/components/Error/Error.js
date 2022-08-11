import './Error.scss'

export const Error = () => {
    return (
        <div className="Error">
            <h1>505 Error</h1>
            <span class="dashicons dashicons-dismiss"></span>
            <p>Something unexpected just happened. Please contact us at <b>some@email.com</b> for more info.</p>
        </div>
    );
};