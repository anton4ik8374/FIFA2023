import React, {useEffect, useState} from 'react';
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import { Doughnut } from 'react-chartjs-2';
import MatchesStore from "@/Stores/MatchesStore";
import {observer} from "mobx-react";

ChartJS.register(ArcElement, Tooltip, Legend);

const CharDoughnut = () => {

    let {match} = MatchesStore;

    let colorsAll = [
        '#009B4D','#FFCC00','#EE72F8',
        '#31EC56', '#00ABE4', '#DD2E18',
        '#2272FF', '#B6E1E7', '#C5ADC5',
        '#00FFFF', '#E7473C', '#178582',
        '#BFA181', '#957C3D', '#002349',
        '#FF595A', '#FEC501', '#FE3A4A',
        '#4F0341', '#FFFFFF', '#4A8BDF',
        '#A0006D', '#0C1A1A', '#6ACFC7',
        '#582C12', '#D668E3',
    ];

    const [labels, setLabels] = useState([]);
    const [numbers, setNumbers] = useState([]);
    const [colors, setColors] = useState([]);

    useEffect(() => {

        if(match?.statistics){
            let labelsUse = [];
            let numbersUse = [];
            let colorsUse = [];
            match?.statistics.map((el, i) => {
                labelsUse.push(el.type);
                numbersUse.push(el.total);
                colorsUse.push(colorsAll[i]);
                return el;
            })
            setLabels(labelsUse);
            setNumbers(numbersUse);
            setColors(colorsUse);
        }
    }, [match]);

    const options = {
        plugins: {
            legend: {
                display: false,
            }
        }
    };
    let data = {
        labels: labels,
        datasets: [
            {
                label: '- such forecasts',
                data: numbers,
                scaleShowLabels : false,
                backgroundColor: colors,
                borderColor: colors,
                borderWidth: 1,
            },
        ],
    };
    return <Doughnut options={options} data={data}/>;
};

export default observer(CharDoughnut);
