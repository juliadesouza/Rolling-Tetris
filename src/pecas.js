class Peca {
    constructor (x, y, tipo, cor, rotacao){
        this.x = x;
        this.y = y;
        this.tipo = tipo;
        this.cor = cor;
        this.rotacao = rotacao;
    }


}
const tetraminoI = [
    [
        [0,0,0,0],
        [1,1,1,1],
        [0,0,0,0],
        [0,0,0,0]
    ],
    [
        [0,0,1,0],
        [0,0,1,0],
        [0,0,1,0],
        [0,0,1,0]
    ],
    [
        [0,0,0,0],
        [0,0,0,0],
        [1,1,1,1],
        [0,0,0,0]
    ],
    [
        [0,1,0,0],
        [0,1,0,0],
        [0,1,0,0],
        [0,1,0,0]
    ]
];

const tetraminoO = [
    [
        [1,1,0,0],
        [1,1,0,0],
        [0,0,0,0],
        [0,0,0,0]
    ]
];

const tetraminoT = [
    [
        [0,1,0],
        [1,1,1],
        [0,0,0]
    ],
    [
        [1,0,0],
        [1,1,0],
        [1,0,0]
    ],
    [
        [1,1,1],
        [0,1,0],
        [0,0,0]
    ],
    [
        [0,1,0],
        [1,1,0],
        [0,1,0]
    ]
];

const tetraminoJ = [
    [
        [0,1,0],
        [0,1,0],
        [1,1,0]
    ],
    [
        [1,0,0],
        [1,1,1],
        [0,0,0]
    ],
    [
        [1,1,0],
        [1,0,0],
        [1,0,0]
    ],
    [
        [1,1,1],
        [0,0,1],
        [0,0,0]
    ]
];

const tetraminoL = [
    [
        [1,0,0],
        [1,0,0],
        [1,1,0]
    ],
    [
        [1,1,1],
        [1,0,0],
        [0,0,0]
    ],
    [
        [1,1,0],
        [0,1,0],
        [0,1,0]
    ],
    [
        [0,0,1],
        [1,1,1],
        [0,0,0]
    ]
];

const tetraminoU = [
    [
        [1,0,1],
        [1,1,1],
        [0,0,0]
    ],
    [
        [1,1,0],
        [1,0,0],
        [1,1,0]
    ],
    [
        [1,1,1],
        [1,0,1],
        [0,0,0]
    ],
    [
        [1,1,0],
        [0,1,0],
        [1,1,0]
    ]
];

const tetraminoE = [
    [
        [0,0,0],
        [1,0,0],
        [0,0,0]
    ],
];