import React, { useEffect, useState  } from 'react'
import 'bootstrap/dist/css/bootstrap.min.css'
import './ParcelView.css'
import './custom.css'
import axios from "axios";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import Moment from 'react-moment';
import 'moment-timezone';

const ParcelView = (props) => {

    const [PENDING, PROCESSING, DELIVERED, CANCELED] = [0, 1, 2, 3];
    const [SENDER, BIKER] = ['sender', 'biker'];

    const [parcel, setParcel]   = useState({});
    const [sender, setSender]   = useState({});
    const [biker, setBiker]     = useState({});
    const [details, setDetails] = useState({});

    const accessToken = localStorage.getItem('accessToken');
    const role = localStorage.getItem('role');

    Moment.globalTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    Moment.globalFormat = 'M/D/Y H:m';

    const fetchParcel = async () => {

        const accessToken = localStorage.getItem('accessToken');

        const response = await axios.get(
            'http://localhost:8000/api/parcels/' + props.match.params.id,
            {headers: {Authorization: 'Bearer ' + accessToken}}
        );

        setParcel(response.data);
        setSender(response.data.sender);
        setBiker(response.data.biker);
        setDetails(response.data.details);
    };

    const cancelHandler = (id) => {

        axios.get(`http://localhost:8000/api/parcels/${id}/cancel`, {headers: {Authorization: 'Bearer ' + accessToken}})
            .then((response) => {
                toast(`Parcel ${parcel.code} canceled`);
                props.history.push('/sender-parcels')
            }).catch(function(err){
            toast.error(err.response.data.message);
        });
    };

    const pickupHandler = id => {
        props.history.push('/parcel-pickup/' + id)
    };

    const deliverHandler = id => {
        props.history.push('/parcel-deliver/' + id)
    };

    useEffect(() => {
        fetchParcel();
    }, []);

    return (
        <div>
            <div className="buttons-wrapper">
                {
                    role == SENDER && (parcel.status == PENDING || parcel.status == PROCESSING) ? (
                        <button className="button cancel-button" onClick={() => cancelHandler(parcel.id)}>Cancel</button>
                    ) : null
                }
                {
                    role == BIKER && parcel.status == PROCESSING ? (
                        <button className="button bg-green" onClick={() => deliverHandler(parcel.id)}>Deliver</button>
                    ) : null
                }
                {
                    role == BIKER && parcel.status == PENDING ? (
                        <button className="button bg-blue" onClick={() => pickupHandler(parcel.id)}>Pick-Up</button>
                    ) : null
                }
            </div>
            <div>
                <strong>Code:</strong>
                <p>#{parcel.code}</p>
            </div>
            <div>
                <strong>Status:</strong>
                <p>{parcel.status_name}</p>
            </div>
            {
                parcel.status == DELIVERED || parcel.status == PROCESSING ? (
                    <div>
                        <strong>Pick-up date:</strong>
                        <p>
                            <Moment>{parcel.pick_up_date}</Moment>
                        </p>
                    </div>
                ) : null
            }
            {
                parcel.status == DELIVERED ? (
                    <div>
                        <strong>delivery date:</strong>
                        <p>
                            <Moment>{parcel.delivery_date}</Moment>
                        </p>
                    </div>
                ) : null
            }
            <div>
                <strong>Pick-up address:</strong>
                <p>{parcel.pick_up_address}</p>
            </div>
            <div>
                <strong>Drop-off address:</strong>
                <p>{parcel.drop_off_address}</p>
            </div>
            <div>
                <strong>Date:</strong>
                <p>
                    <Moment>{parcel.created_at}</Moment>
                </p>
            </div>
            {
                details.weight ? (
                    <div>
                        <strong>Weight:</strong>
                        <p>{details.weight} Gram</p>
                    </div>
                ) : null
            }
            {
                details.note ? (
                    <div>
                        <strong>Note:</strong>
                        <p>{details.note}</p>
                    </div>
                ) : null
            }
            {
                role === BIKER ? (
                    <div>
                        <strong>Sender: </strong>
                        <div className="sender-block">
                            <div>
                                <strong>Name: </strong>
                                <p>{sender.full_name}</p>
                            </div>
                            <div>
                                <strong>Mobile: </strong>
                                <p>{sender.mobile}</p>
                            </div>
                        </div>
                    </div>
                ) : null
            }
            <div>
                {
                    role === SENDER && parcel.biker_id > 0 ? (
                        <div>
                            <strong>Biker: </strong>
                            <div className="biker-block">
                                <div>
                                    <strong>Name: </strong>
                                    <p>{biker.full_name}</p>
                                </div>
                                <div>
                                    <strong>Mobile: </strong>
                                    <p>{biker.mobile}</p>
                                </div>
                            </div>
                        </div>
                    ) : null
                }
            </div>
            <ToastContainer/>
        </div>
    )
}

export default ParcelView