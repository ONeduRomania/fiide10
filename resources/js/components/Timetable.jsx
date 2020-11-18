import React from 'react'
import ReactDOM from 'react-dom'
import Timetable from 'react-timetable-events'
import moment from 'moment';

export default class TimetableComponent extends React.Component {
    constructor(props) {
        super(props)

        var mondayEvents = [], tuesdayEvents = [], wednesdayEvents = [], thursdayEvents = [], fridayEvents = []
        var timestamps = JSON.parse(this.props.timetable)

        timestamps.map(timestamp => {
            var dates = JSON.parse(timestamp.data)
            switch(moment(dates.startDate).day()) {
                case 1: mondayEvents.push({id: timestamp.id, name: timestamp.subjects.name, startTime: moment(dates.startTime), endTime: moment(dates.endTime)})
                    break
                case 2: tuesdayEvents.push({id: timestamp.id, name: timestamp.subjects.name, startTime: moment(dates.startTime), endTime: moment(dates.endTime)})
                    break
                case 3: wednesdayEvents.push({id: timestamp.id, name: timestamp.subjects.name, startTime: moment(dates.startTime), endTime: moment(dates.endTime)})
                    break
                case 4: thursdayEvents.push({id: timestamp.id, name: timestamp.subjects.name, startTime: moment(dates.startTime), endTime: moment(dates.endTime)})
                    break
                case 5: fridayEvents.push({id: timestamp.id, name: timestamp.subjects.name, startTime: moment(dates.startTime), endTime: moment(dates.endTime)})
                    break
            }
        })

        this.state = {
            data: {
                monday: mondayEvents,
                tuesday: tuesdayEvents,
                wednesday: wednesdayEvents,
                thursday: thursdayEvents,
                friday: fridayEvents
            }
        }
    }

    render() {
        return <Timetable events={this.state.data} />
    }
}

if (document.getElementById('timetable-component')) {
    const element = document.getElementById('timetable-component')
    const props = Object.assign({}, element.dataset)

    ReactDOM.render(<TimetableComponent {...props}/>, element)
}
