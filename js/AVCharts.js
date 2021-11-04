function getHeight(element) {
    element.style.visibility = "hidden";
    document.body.appendChild(element);
    var height = element.offsetHeight + 0;
    document.body.removeChild(element);
    element.style.visibility = "visible";
    return height;
}

function newBarChart(chartBase, data) {
    // preparing data
    const labels = data.labels;
    const values = data.values;
    const hoverBoxData = data.hoverBoxData;

    var largestValue = values[0];
    for (var i = 0; i < values.length; i++) {
        if (values[i] > largestValue) {
            largestValue = values[i];
        }
    }
    const largestDataPoint = largestValue + 15;
    var dataPoints = [
        Math.round(largestDataPoint),
        Math.round((largestDataPoint / 7) * 6),
        Math.round((largestDataPoint / 7) * 5),
        Math.round((largestDataPoint / 7) * 4),
        Math.round((largestDataPoint / 7) * 3),
        Math.round((largestDataPoint / 7) * 2),
        Math.round(largestDataPoint / 7),
    ];

    // y-axis
    const chartYE = document.createElement("div");
    chartYE.classList.add("chart-y");
    chartYE.style.gridRowGap = `${largestDataPoint / 7 - 0.5}px`;

    for (var i = 0; i < dataPoints.length; i++) {
        const yMarkE = document.createElement("div");
        yMarkE.classList.add("y-mark");
        const markLabelE = document.createElement("div");
        markLabelE.classList.add("mark-label");
        markLabelE.innerHTML = dataPoints[i];
        yMarkE.appendChild(markLabelE);
        chartYE.appendChild(yMarkE);
    }

    // x-axis
    const chartXE = document.createElement("div");
    chartXE.classList.add("chart-x");
    chartXE.style.gridTemplateColumns = "auto ".repeat(labels.length);

    for (var i = 0; i < labels.length; i++) {
        const xLabelE = document.createElement("img");
        xLabelE.classList.add("x-label");
        xLabelE.setAttribute("src", labels[i]);
        chartXE.appendChild(xLabelE);
    }

    // increment data
    const chartHeight = getHeight(chartYE);
    const totalIncrements = largestDataPoint;
    const chartIncrementInPx = chartHeight / totalIncrements;
    console.log(chartHeight);
    console.log(totalIncrements);

    // bars
    const chartBarsE = document.createElement("div");
    chartBarsE.classList.add("chart-bars");
    chartBarsE.style.gridTemplateColumns = "auto ".repeat(labels.length);

    var prevColor = "var(--red5)";
    for (var i = 0; i < values.length; i++) {
        const barsBar = document.createElement("div");
        barsBar.classList.add("bars-bar");
        barsBar.style.height = `${values[i] * chartIncrementInPx}px`;
        barsBar.style.transform = `translate(28.5px, -${
            values[i] * chartIncrementInPx + 5
        }px)`;

        if (prevColor == "var(--red5)") {
            barsBar.style.backgroundColor = "var(--blue2)";
            prevColor = "var(--blue2)";
        } else if (prevColor == "var(--blue2)") {
            barsBar.style.backgroundColor = "var(--red2)";
            prevColor = "var(--red2)";
        } else if (prevColor == "var(--red2)") {
            barsBar.style.backgroundColor = "var(--red4)";
            prevColor = "var(--red4)";
        } else if (prevColor == "var(--red4)") {
            barsBar.style.backgroundColor = "#c06d85ff";
            prevColor = "var(--red5)";
        }

        // Hover Boxes
        const barsBarBarHoverBox = document.createElement("div");
        barsBarBarHoverBox.classList.add("bar-hover-box");
        const hoverBoxTable = document.createElement("table");
        for (var j = 0; j < hoverBoxData[i].length; j++) {
            const tableRow = document.createElement("tr");
            const tableResolutionsCol = document.createElement("td");
            tableResolutionsCol.innerHTML = `<b>${hoverBoxData[i][j].resolution}</b>`;
            const tableCarbonFootprintCol = document.createElement("td");
            tableCarbonFootprintCol.innerHTML = `${hoverBoxData[i][j].carbonFootprint} kg`;
            tableRow.appendChild(tableResolutionsCol);
            tableRow.appendChild(tableCarbonFootprintCol);
            hoverBoxTable.appendChild(tableRow);
        }
        barsBarBarHoverBox.appendChild(hoverBoxTable);
        barsBarBarHoverBox.style.transform = `translateY(-${getHeight(
            barsBarBarHoverBox
        )}px)`;
        barsBar.appendChild(barsBarBarHoverBox);

        chartBarsE.appendChild(barsBar);
    }

    chartBase.appendChild(chartYE);
    chartBase.appendChild(chartXE);
    chartBase.appendChild(chartBarsE);
}
