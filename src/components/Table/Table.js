import './Table.scss';

export const Table = ({ data, hiddenColumns = [] }) => {
    const { title, data: table } = data;

    return (
        <div className="Table">
            <h4>{title}</h4>
            <table>
                <thead>
                    <tr>
                        {table.headers
                        .filter((col, index) => ! hiddenColumns.includes(`column_${index}`))
                        .map(
                            (col) => {
                                return (
                                    <th>{col}</th>
                                );

                            }     
                        )}
                    </tr>
                </thead>
                <tbody>
                    {Object.values(table.rows).map((row) => {
                        return (
                            <tr>
                                {Object.values(row)
                                .filter((col, index) => ! hiddenColumns.includes(`column_${index}`))
                                .map((col) => {
                                    return <td>{col}</td>
                                })}
                            </tr>
                        );
                    })}
                </tbody>
            </table>
        </div>
    );
};