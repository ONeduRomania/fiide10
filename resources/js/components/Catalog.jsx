import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import Select from 'react-select'
import axios from 'axios'

export default class Catalog extends Component {
    constructor(props) {
        super(props)

        this.state = {
            notes: JSON.parse(this.props.logs),
            name: this.props.name,
            subjects: JSON.parse(this.props.subjects),
            id: '',
            sub: '',
            mean_first: '',
            mean_second: '',
            mean_final: '',
            selectOptions: [],
            marks_first: [],
            marks_second: [],
            absence_first: [],
            absence_second: [],
            noAbs_first: 0,
            noAbs_second: 0,
        }
    }
    // A bit catchy not gonna lie, verifica de ce face scheme si ayaye
    async deleteLog(e, id) {
        console.log(id)
        await axios.delete('http://localhost:8000/school/' + this.props.school + '/classes/' + this.props.class + '/log/' + id)
            .then(res => {})
            .catch(err => console.log(err))
        // window.location.reload(false)
    }

    handleChange(e){
        this.setState({id: e.value, sub: e.label})
        this.setState({marks_first: [], marks_second: [], absence_first: [], absence_second: [], mean_first: '', noAbs_first: 0, noAbs_second: 0})

        var mFirst = [], mSecond = [], aFirst = [], aSecond = [], fMean = '', sMean = '', aMean = '', sum_first = 0, sum_second = 0, absFirst = 0, absSecond = 0
        const FIRST_TERM = "1", MARK = 2

        this.state.notes.map(note => {
            if (note.subject === e.value) {
                var data = JSON.parse(note.data)
                if (data.term === FIRST_TERM) {
                    if (note.type === MARK) {
                        mFirst.push({id: note.id, mark: data.mark, date: data.date})
                        sum_first += Number(data.mark)
                    }
                    else {
                        aFirst.push({id: note.id, date: data.date, motivated: data.deleted})

                        if (data.deleted === null) {
                            absFirst++;
                        }
                    }
                } else {
                    if (note.type === MARK) {
                        mSecond.push({id: note.id, mark: data.mark, date: data.date})
                        sum_second += Number(data.mark)
                    }
                    else {
                        aSecond.push({id: note.id, date: data.date, motivated: data.deleted})

                        if (data.deleted === null) {
                            absSecond++;
                        }
                    }
                }
            }
        })
        if (sum_first !== 0) fMean = Math.round(sum_first / mFirst.length);
        if (sum_second !== 0) sMean = Math.round(sum_second / mSecond.length);
        if (sum_second !== 0 && sum_first !== 0)
            aMean = (Number(fMean) + Number(sMean)) / 2

        this.setState({marks_first: mFirst, marks_second: mSecond, absence_first: aFirst, absence_second: aSecond, mean_first: fMean, mean_second: sMean, mean_final: aMean, noAbs_first: absFirst, noAbs_second: absSecond})
    }

    getOptions() {
        const options = this.state.subjects.map(subject => ({
            "value": subject.id,
            "label": subject.name
        }))

        this.setState({selectOptions: options})
    }

    componentDidMount(){
        this.getOptions()
    }

    render() {
        return (
            <div className="card shadow-lg">
                <div className="card-body">
                    <div className="form-group">
                        <Select options={this.state.selectOptions} onChange={this.handleChange.bind(this)} />
                    </div>
                    {this.props.logs
                        ?
                        <div className="my-3">
                            <div className="row">
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="text-muted">Nume</span>
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="text-muted">Număr de note</span>
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="text-muted">Număr de absențe</span>
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="text-muted">Media</span>
                                </div>
                            </div>
                            <hr/>
                            <div className="row">
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="text-royal"><strong>{this.state.name}</strong></span>
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="badge badge-royal"><strong>SEMESTRUL I: {this.state.marks_first.length}</strong></span>
                                    <br/>
                                    <span className="badge badge-royal"><strong>SEMESTRUL II: {this.state.marks_second.length}</strong></span>
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="badge badge-dark"><strong>SEMESTRUL I: {this.state.absence_first.length}</strong></span>
                                    <br/>
                                    <span className="badge badge-dark"><strong>SEMESTRUL II: {this.state.absence_second.length}</strong></span>
                                </div>
                            </div>
                            <hr/>
                            <div className="row">
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="text-muted">Semestrul I</span>
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    {
                                        this.state.marks_first.map(mark =>
                                            <span onClick={(e) => this.deleteLog(e, mark.id)} key={mark.id} className="badge badge-gray mx-1">{mark.mark} / {mark.date}</span>
                                        )
                                    }
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    {
                                        this.state.absence_first.map(absence =>
                                            <span onClick={(e) => this.deleteLog(e, absence.id)} key={absence.id} className={`badge ${absence.motivated === null ? 'badge-danger' : 'badge-royal'} mx-1`}>{absence.date}</span>
                                        )
                                    }
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="badge badge-success">{this.state.mean_first}</span>
                                </div>
                            </div>
                            <hr/>
                            <div className="row">
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="text-muted">Semestrul II</span>
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    {
                                        this.state.marks_second.map(mark =>
                                            <span onClick={(e) => this.deleteLog(e, mark.id)} key={mark.id} className="badge badge-gray mx-1">{mark.mark} / {mark.date}</span>
                                        )
                                    }
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    {
                                        this.state.absence_second.map(absence =>
                                            <span onClick={(e) => this.deleteLog(e, absence.id)} key={absence.id} className={`badge ${absence.motivated === null ? 'badge-danger' : 'badge-dark'} mx-1`}>{absence.date}</span>
                                        )
                                    }
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="badge badge-success">{this.state.mean_second}</span>
                                </div>
                            </div>
                            <hr/>
                            <div className="row">
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="text-muted">Anual</span>
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="badge badge-secondary">{this.state.marks_first.length + this.state.marks_second.length}</span>
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="badge badge-secondary">Total: {this.state.absence_first.length + this.state.absence_second.length} / Nemotivate: {this.state.noAbs_first + this.state.noAbs_second}</span>
                                </div>
                                <div className="col-md-12 col-lg-3 text-center">
                                    <span className="badge badge-success">{this.state.mean_final}</span>
                                </div>
                            </div>
                        </div>
                        : <small className="text-muted">Nu există nicio înregistrare.</small>
                    }
                </div>
            </div>
        )
    }
}

if (document.getElementById('catalog-component')) {
    const element = document.getElementById('catalog-component')
    const props = Object.assign({}, element.dataset)

    ReactDOM.render(<Catalog {...props} />, element)
}
