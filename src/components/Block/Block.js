import React from 'react'; 
import {InspectorControls } from '@wordpress/block-editor';
import { ColumnsVisibility } from '../ColumnsVisibility/ColumnsVisibility';
import { Table }   from '../Table/Table';
import { Error }   from '../Error/Error';
import { Loading } from '../Loading/Loading';

export const Block = ({ attributes, setAttributes }) => {
    const [ error, setError ] = React.useState(false);
    const { adminVars, data, hiddenColumns } = attributes;

    const setHiddenColumns = (hiddenColumns) => {
        setAttributes({ hiddenColumns });
    }

    const renderBlock = () => {
        if (!!error) {
            return <Error error={error} />
        }
        
        if (!!data) {
            return (
                <>
                    <InspectorControls key="setting">
                        <ColumnsVisibility
                            columns={data?.data?.headers}
                            hiddenColumns={hiddenColumns} 
                            setHiddenColumns={setHiddenColumns} 
                        />
                    </InspectorControls> 

                    <Table data={data} hiddenColumns={hiddenColumns} />
                </>
            )
        }
    
        return <Loading />
    };

    React.useEffect(() => {
        jQuery.post(
            adminVars.url,
            {
                challenge_id: 1, // There's only one resource for now, but it could change in the future.
                action: adminVars.action,
                wpnonce: adminVars.nonce,
            },
            ({ data, success }) => {
                if (!success) {
                    return setError(true);
                }
    
                setAttributes({ data });
            }
        );
    }, []);

    return (
        <>
            {renderBlock()}
        </>
    );
}