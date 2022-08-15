import './Error.scss'

export const Error = () => {
    const { __ } = wp.i18n;
    return (
        <div className="Error">
            <h1>{__('505 Error', 'am-apiplugin')}</h1>
            <span class="dashicons dashicons-dismiss"></span>
            <p>
                {__('Something unexpected just happened. Try to reload the page.', 'am-apiplugin')}
            </p>
        </div>
    );
};