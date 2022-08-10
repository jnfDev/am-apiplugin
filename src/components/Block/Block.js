import {InspectorControls } from '@wordpress/block-editor';
import { ColumnsVisibility } from '../ColumnsVisibility/ColumnsVisibility';
import { Table }   from '../Table/Table';
import { Error }   from '../Error/Error';
import { Loading } from '../Loading/Loading';

export const Block = ({ attributes, setAttributes }) => {
    const { adminVars, error, data, hiddenColumns } = attributes;

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

    if (!data) {
        // TODO: useEffect
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
        <div className='Block'>
            {renderBlock()}
        </div>
    );
}