import './Table.scss';

export const Table = ({ data, hiddenColumns }) => {
    const { title, data: table } = data;
    const _hiddenColumns = hiddenColumns || {}; 

    return (
        <div>
            <h4>{title}</h4>
            <table>
                <thead>
                    <tr>
                        {table.headers
                        .filter((col) => ! Object.values(_hiddenColumns).includes(col))
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
                                {Object.entries(row)
                                .filter(([ key, value ]) => ! Object.keys(_hiddenColumns).includes(key))
                                .map(
                                    ([ key, value ]) => {
                                        return <td>{value}</td>
                                    }
                                )}
                            </tr>
                        );
                    })}
                </tbody>
            </table>
        </div>
    );
};