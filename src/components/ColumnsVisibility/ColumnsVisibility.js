import { ToggleControl } from '@wordpress/components';
import './ColumnsVisibility.scss';

export const ColumnsVisibility = ({ columns = [], setHiddenColumns, hiddenColumns = [] }) => {
    const { __, sprintf } = wp.i18n;
    return (
        <div className='Am-ColumnsVisibility'>
            {columns.map((col, index) => {
                const isHidden = hiddenColumns.includes(`column_${index}`);
                return (
                    <ToggleControl
                        label={sprintf(__('Hide %s', 'am-apiplugin'), col)}
                        help={
                            isHidden
                                ? __('Hidden', 'am-apiplugin')
                                : __('Visible', 'am-apiplugin')
                        }
                        checked={isHidden}
                        onChange={checked => {
                            if (checked) {
                                setHiddenColumns(hiddenColumns.concat([`column_${index}`]));
                                return;
                            }
                            
                            setHiddenColumns(hiddenColumns.filter(col => col !== `column_${index}`));
                        }}
                    />
                );
            })}
        </div>
    )
};