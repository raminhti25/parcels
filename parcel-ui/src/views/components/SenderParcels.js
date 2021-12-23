import React, { useState, useEffect, useMemo  } from 'react'
import DataTable from 'react-data-table-component'
import 'bootstrap/dist/css/bootstrap.min.css'
import axios from "axios";
import './custom.css';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import Moment from 'react-moment';
import 'moment-timezone';


const SenderParcels = (props) => {

    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(false);
    const [totalRows, setTotalRows] = useState(0);
    const [perPage, setPerPage] = useState(10);
    const [currentPage, setCurrentPage] = useState(1);
    const accessToken = localStorage.getItem('accessToken');
    const [PENDING, PROCESSING, DELIVERED, CANCELED] = [0, 1, 2, 3];

    Moment.globalTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    Moment.globalFormat = 'M/D/Y H:m';

    const fetchParcels = async (page, size = perPage) => {

        setLoading(true);

        const response = await axios.get(
            `http://localhost:8000/api/senders/parcels?page=${page - 1}&length=${size}`,
            {headers: {Authorization: 'Bearer ' + accessToken}}
        );

        setData(response.data.data);
        setTotalRows(response.data.total);
        setLoading(false);
    };

    useEffect(() => {
        fetchParcels(1);
    }, []);

    const cancelHandler = (row) => {

        const id = row['id'];

        axios.get(`http://localhost:8000/api/parcels/${id}/cancel`, {headers: {Authorization: 'Bearer ' + accessToken}})
            .then((response) => {
                fetchParcels(1);
                toast(`Parcel ${row['code']} canceled`);
            })
            .catch(function(err){
                toast.error(err.response.data.message);
            });

        // setData(removeItem(response.data.data, row));
        setTotalRows(totalRows - 1);
    }

    const viewHandler = (row) => {
        props.history.push('/parcel-view/' + row['id'])
    };

    const columns = useMemo(
        () => [
            {
                name: "Code",
                sortable: true,
                cell: row => '#' + row['code']
            },
            {
                name: "Status",
                selector: "status_name",
                sortable: true
            },
            {
                name: "Date",
                selector: "created_at",
                sortable: true,
                cell: row => <Moment>{row['created_at']}</Moment>
            },
            {
                cell: row => <button className="button bg-blue" onClick={() => viewHandler(row)}>View</button>
            },
            {
                cell: row => row['status'] == PENDING || row['status'] == PROCESSING ? (
                    <button className="button cancel-button" onClick={() => cancelHandler(row)}>Cancel</button>
                ) : null
            }
        ],
    );

    const handlePageChange = page => {
        fetchParcels(page);
        setCurrentPage(page);
    };

    const handlePerRowsChange = async (newPerPage, page) => {
        fetchParcels(page, newPerPage);
        setPerPage(newPerPage);
    };

    return (
        <div>
            <DataTable
                title="Parcels"
                columns={columns}
                data={data}
                progressPending={loading}
                pagination
                paginationServer
                paginationTotalRows={totalRows}
                paginationDefaultPage={currentPage}
                onChangeRowsPerPage={handlePerRowsChange}
                onChangePage={handlePageChange}
            />
            <ToastContainer/>
        </div>
    );

}

export default SenderParcels
