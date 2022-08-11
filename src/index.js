import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor'
import { Block } from './components/Block/Block';
import { Table } from './components/Table/Table';
 
registerBlockType( 'am-apiplugin/am-apiblock', {
    edit: ({ attributes, setAttributes }) => (
        <div { ...useBlockProps() } >
            <Block
                attributes={attributes} 
                setAttributes={setAttributes} 
            />
        </div>
    ),
    save: ({ attributes }) => {
        const { data, hiddenColumns } = attributes;

        if (!data) {
            return;
        }

        return (
            <div { ...useBlockProps.save() } >
                <Table data={data} hiddenColumns={hiddenColumns} />
            </div>
        );
    },
} );