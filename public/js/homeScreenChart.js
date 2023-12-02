let ctx = document.getElementById('graph');
let chart;
async function getData(url) {
    try {
        let response = await fetch(url);
        let data = await response.json();
        return data;
    }
    catch (err) {
        console.error("Error: ", err);
        document.getElementById('errorMessage').style.display = 'block';
    }
}
async function init() {
    let categoryAndAverage = await getData(`/api/categories/get-averages`);
    let overallSatisfaction = 0;
    let sum = 0;

    if (categoryAndAverage !== null || categoryAndAverage !== undefined) {
        
        let labels = [];
        let values = [];
        categoryAndAverage.forEach(categoryAndAverage => {
            labels.push(categoryAndAverage.category);
            values.push(categoryAndAverage.average);
            sum += categoryAndAverage.average;
        });

        const data = {
            labels: labels,
            datasets: [{
                label: "Average rating of category",
                data: values,
                borderWidth: 1
            }]
        }
        chart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    customCanvasBackgroundColor: {
                        color: 'lightGreen',
                    }
                }
            },
        });
        setProgress(sum / values.length);
    }
    else
        document.getElementById('errorMessage').style.display = 'block';
}

function setProgress(value) {
    const progressBar = document.querySelector('#prog-bar-cont #prog-bar #background');
    const progressText = document.querySelector('.progress-text');
    const max = 10;
    const percent = (value / max) * 100;
    progressBar.style.clipPath = `inset(0 ${(100 - percent).toFixed(2)}% 0 0)`;

    let currentProgress = 0;
    const increment = value / 100;
    const progressInterval = setInterval(() => {
        currentProgress += increment;
        progressText.textContent = currentProgress.toFixed(2);
        if (currentProgress >= value) {
            clearInterval(progressInterval);
        }
    }, 10);
}

const plugin = {
    id: 'customCanvasBackgroundColor',
    beforeDraw: (chart, args, options) => {
        const {ctx} = chart;
        ctx.save();
        ctx.globalCompositeOperation = 'destination-over';
        ctx.fillStyle = options.color || '#99ffff';
        ctx.fillRect(0, 0, chart.width, chart.height);
        ctx.restore();
    }
};

init();


function lineChartSelected(){
    selectedGraph = "line";
    const ctx = document.getElementById('graph');
    let selectedValue = selectedGraph;
    let temp = chart.config;
    temp.type = selectedValue.toString();
    chart.destroy();
    chart = new Chart(ctx, temp);

}
function barChartSelected(){
    selectedGraph = "bar";
    const ctx = document.getElementById('graph');
    let selectedValue = selectedGraph;
    let temp = chart.config;
    temp.type = selectedValue.toString();
    chart.destroy();
    chart = new Chart(ctx, temp);
}


