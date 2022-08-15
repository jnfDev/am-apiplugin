import './Loading.scss';

export const Loading = () => {
    const { __ } = wp.i18n;
    return (
        <div className="Loading">
            <span class="dashicons dashicons-admin-site-alt3"></span>
            <h5>{__('Loading...', 'am-apiplugin')}</h5>
        </div>
    );
};