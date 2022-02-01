function getHeight(element) {
    element.style.visibility = "hidden";
    document.body.appendChild(element);
    let height = element.offsetHeight + 0;
    document.body.removeChild(element);
    element.style.visibility = "visible";
    return height;
}

function newBarChart(chartBase, data) {
    // preparing data
    const labels = data.labels;
    const values = data.values;
    const hoverBoxData = data.hoverBoxData;

    let largestValue = values[0];
    for (let i = 0; i < values.length; i++) {
        if (values[i] > largestValue) {
            largestValue = values[i];
        }
    }
    const largestDataPoint = largestValue + 15;
    let dataPoints = [
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

    for (let i = 0; i < dataPoints.length; i++) {
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

    for (let i = 0; i < labels.length; i++) {
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

    let prevColor = "var(--red4)";
    for (let i = 0; i < values.length; i++) {
        const barsBar = document.createElement("div");
        barsBar.classList.add("bars-bar");
        barsBar.style.height = `${values[i] * chartIncrementInPx}px`;
        barsBar.style.transform = `translate(28.5px, -${
            values[i] * chartIncrementInPx + 2
        }px)`;
        const barsBarBarHoverBox = document.createElement("div");

        if (prevColor === "var(--red4)") {
            barsBar.classList.remove("bg-red4");
            barsBar.classList.add("bg-blue2");
            barsBarBarHoverBox.classList.add("border-top-blue");
            prevColor = "var(--blue2)";
        } else if (prevColor === "var(--blue2)") {
            barsBar.classList.remove("bg-blue2");
            barsBar.classList.add("bg-red2");
            barsBarBarHoverBox.classList.add("border-top-pink");
            prevColor = "var(--red2)";
        } else if (prevColor === "var(--red2)") {
            barsBar.classList.remove("bg-red2");
            barsBar.classList.add("bg-red4");
            barsBarBarHoverBox.classList.add("border-top-purple");
            prevColor = "var(--red4)";
        }

        // Hover Boxes
        barsBarBarHoverBox.classList.add("bar-hover-box");
        const hoverBoxTable = document.createElement("table");
        for (let j = 0; j < hoverBoxData[i].length; j++) {
            const tableRow = document.createElement("tr");
            const tableResolutionsCol = document.createElement("td");
            if (hoverBoxData[i][j].resolution === "1920x1080" || hoverBoxData[i][j].resolution === "1920x960") {
                tableResolutionsCol.innerHTML = `<b>1080p</b>`;
            } else if (hoverBoxData[i][j].resolution === "2560x1280") {
                tableResolutionsCol.innerHTML = `<b>1440p</b>`;
            } else if (hoverBoxData[i][j].resolution === "3840x1920") {
                tableResolutionsCol.innerHTML = `<b>2160p</b>`;
            } else {
                tableResolutionsCol.innerHTML = `<b>${hoverBoxData[i][j].resolution}</b>`;
            }
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
