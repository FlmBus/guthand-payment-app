const tag = strings => {
    console.log(strings.raw[0]);
};

async function main() {
    tag`Line 1
    Line 2`;
}

main();