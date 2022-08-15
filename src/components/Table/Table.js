import './Table.scss';

export const Table = ({ data, hiddenColumns = [] }) => {
    const { title, data: table } = data;

    const dateIndex = table.headers.reduce((_default, col, index) => {
        return ('Date' === col) ? index : _default;
    }, -1);

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
                                .map((col, index) => {
                                    // Let's format any "Date" column
                                    if (index === dateIndex) {
                                        col = (new Date(col)).toLocaleDateString();
                                    }
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