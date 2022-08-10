import {InspectorControls } from '@wordpress/block-editor';
import { BlockSettings } from '../BlockSettings/BlockSettings';
import { Table }   from '../Table/Table';
import { Error }   from '../Error/Error';
import { Loading } from '../Loading/Loading';

export const Block = ({ attributes, setAttributes }) => {
    const { adminVars, error, data, hiddenColumns } = attributes;

    const setHiddenColumns = (hiddenColumns) => {
        setAttributes({ hiddenColumns });
    }

    const render = () => {
        if (!!error) {
            return <Error error={error} />
        }
        
        if (!!data) {
            return <Table data={data} hiddenColumns={hiddenColumns} />
        }
    
        return <Loading />
    };

    if (!data) {
        jQuery.post(
            adminVars.url,
            {
                action: adminVars.action,
                wpnonce: adminVars.nonce,
            },
            ({ data, success }) => {
                if (!success) {
                    return setAttributes({ error: data.errorMessage });
                }

                setAttributes({ data });
            }
        );
    }

    return (
        <div>
            <InspectorControls key="setting">
                <BlockSettings 
                    hiddenColumns={hiddenColumns} 
                    setHiddenColumns={setHiddenColumns} 
                />
            </InspectorControls>
            {render()}
        </div>
    );
}