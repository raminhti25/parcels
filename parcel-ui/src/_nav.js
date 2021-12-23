import React from 'react'
import CIcon from '@coreui/icons-react'
import {
    cilBell,
    cilCalculator,
    cilChartPie,
    cilCursor,
    cilDrop,
    cilNotes,
    cilPencil,
    cilPuzzle,
    cilSpeedometer,
    cilStar,
} from '@coreui/icons'
import { CNavGroup, CNavItem, CNavTitle } from '@coreui/react'

let _nav = [];

if (localStorage.getItem('role') == 'sender') {
    _nav.push({
        component: CNavItem,
        name: 'Parcels',
        to: '/sender-parcels',
        icon: <CIcon icon={cilSpeedometer} customClassName="nav-icon" />,
    });

    _nav.push({
        component: CNavItem,
        name: 'New Parcel',
        to: '/new-parcel',
        icon: <CIcon icon={cilSpeedometer} customClassName="nav-icon" />,
    });

} else {
    _nav.push(
        {
            component: CNavItem,
            name: 'Parcels',
            to: '/biker-parcels',
            icon: <CIcon icon={cilSpeedometer} customClassName="nav-icon" />,
        }
    )
}

export default _nav
