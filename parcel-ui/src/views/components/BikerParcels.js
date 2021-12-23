import React, { useEffect, useState  } from 'react'
import 'bootstrap/dist/css/bootstrap.min.css'
import axios from "axios";
import './BikerParcels.css';
import './custom.css';
import Moment from 'react-moment';
import 'moment-timezone';


const BikerParcels = (props) => {

    const [parcels, setParcels] = useState([]);
    const [PENDING, PROCESSING, DELIVERED, CANCELED] = [0, 1, 2, 3];
    const [length, setLength] = useState(10);
    const [total, setTotal] = useState(0);

    Moment.globalTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    Moment.globalFormat = 'M/D/Y H:m';

    const fetchParcels = async (size) => {

        const accessToken = localStorage.getItem('accessToken');

        const response = await axios.get(
            'http://localhost:8000/api/bikers/parcels?length=' + size,
            {headers: {Authorization: 'Bearer ' + accessToken}}
        );

        setParcels(response.data.data);
        setTotal(response.data.total)
    };

    const moreHandler = () => {
        let newLength = length + 10;
        setLength(newLength);
        fetchParcels(newLength);
    };

    const viewHandler = id => {
        props.history.push('/parcel-view/' + id)
    };

    const pickupHandler = id => {
        props.history.push('parcel-pickup/' + id)
    };

    const deliverHandler = id => {
        props.history.push('parcel-deliver/' + id)
    };

    useEffect(() => {
        fetchParcels(length);
    }, []);

    return (
        <div>
            <ul className="list">
                {
                    parcels.map(function(parcel) {
                        return (
                            <li key={parcel.id}>
                            <span>
                                <strong>#{parcel.code}</strong>
                            </span>
                                <span>
                                <strong>Status: </strong>{parcel.status_name}
                            </span>
                                <span>
                                <strong>Date: </strong><Moment>{parcel.created_at}</Moment>
                            </span>
                                <div className="buttons-wrapper">
                                    {
                                        parcel.status == PROCESSING ? (
                                            <button className="button bg-green" onClick={() => deliverHandler(parcel.id)}>Deliver</button>
                                        ) : null
                                    }
                                    <button className="button bg-yellow color-black" onClick={() => viewHandler(parcel.id)}>View</button>
                                    {
                                        parcel.status == PENDING ? (
                                            <button className="button bg-blue" onClick={() => pickupHandler(parcel.id)}>Pick-Up</button>
                                        ) : null
                                    }
                                </div>
                            </li>
                        )
                    })
                }
            </ul>
            {
                total > 10 && length < total ? (
                    <button className="button more-btn" onClick={moreHandler}>Load More</button>
                ) : null
            }
        </div>
    )
};

export default BikerParcels;