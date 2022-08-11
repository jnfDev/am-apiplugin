import { ToggleControl } from '@wordpress/components';
import './ColumnsVisibility.scss';

export const ColumnsVisibility = ({ columns = [], setHiddenColumns, hiddenColumns = [] }) => {
    return (
        <div className='Am-ColumnsVisibility'>
            {columns.map((col, index) => {
                const isHidden = hiddenColumns.includes(`column_${index}`);
                return (
                    <ToggleControl
                        label={`Hide ${col}`}
                        help={
                            isHidden
                                ? 'Hidden'
                                : 'Visible'
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