import { ToggleControl } from '@wordpress/components';

export const BlockSettings = ({ hiddenColumns, setHiddenColumns }) => {
    const _hiddenColumns = hiddenColumns || {};    

    const hideID    = _hiddenColumns.id ? true : false;
    const hideFname = _hiddenColumns.fname ? true : false;
    const hideLname = _hiddenColumns.lname ? true : false;
    const hideEmail = _hiddenColumns.email ? true : false;
    const hideDate  = _hiddenColumns.date ? true : false;
    
    return (
        <div className='block-settings'>
            <ToggleControl
                label = "Hide ID"
                help = {
                    hideID
                        ? 'Hidden'
                        : 'Visible.'
                }
                checked={!hideID}
                onChange={checked => {
                    if ( checked ) {
                        delete _hiddenColumns.id;
                    } else {
                        _hiddenColumns.id = 'ID'
                    }

                    setHiddenColumns({..._hiddenColumns });
                }}
            />

            <ToggleControl
                label = "Hide First Name"
                help = {
                    hideFname
                        ? 'Hidden'
                        : 'Visible.'
                }
                checked={!hideFname}
                onChange={checked => {
                    if ( checked ) {
                        delete _hiddenColumns.fname;
                    } else {
                        _hiddenColumns.fname = 'First Name';
                    }

                    setHiddenColumns({..._hiddenColumns });
                }}
            />
            
            <ToggleControl
                label = "Hide Last Name"
                help = {
                    hideLname
                        ? 'Hidden'
                        : 'Visible'
                }
                checked={!hideLname}
                onChange={checked => {
                    if ( checked ) {
                        delete _hiddenColumns.lname;
                    } else {
                        _hiddenColumns.lname = 'Last Name';
                    }

                    setHiddenColumns({..._hiddenColumns });
                }}
            />

            <ToggleControl
                label = "Hide Email"
                help = {
                    hideEmail
                        ? 'Hidden'
                        : 'Visible'
                }
                checked={!hideEmail}
                onChange={checked => {
                    if ( checked ) {
                        delete _hiddenColumns.email;
                    } else {
                        _hiddenColumns.email = 'Email';
                    }

                    setHiddenColumns({..._hiddenColumns });
                }}
            />

            <ToggleControl
                label = "Hide Date"
                help = {
                    hideDate
                        ? 'Hidden'
                        : 'Visible'
                }
                checked={!hideDate}
                onChange={checked => {
                    if ( checked ) {
                        delete _hiddenColumns.date;
                    } else {
                        _hiddenColumns.date = 'Date';
                    }

                    setHiddenColumns({..._hiddenColumns });
                }}
            />
            
        </div>
    )
};