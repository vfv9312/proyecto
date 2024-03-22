<?php

namespace Database\Seeders;

use App\Models\productos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $productos = [
            [
                1, 13, 1, 5, 1, 'HP 662XL',
                'DeskJet INK Advantage, 1015, 1515, 1516, 2515, 2516, 2545, 2546, 2645, 2646, 3515, 3516, 3545, 3546, 3565, 4645, 4646',
                'Rendimiento: 300 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240314235623_AjgPb07OiT.webp',
                '2024-03-14 23:56:23', '2024-03-14 23:56:23', null, 1
            ],
            [
                2, 13, 1, 1, 3,
                'HP 670', 'DeskJet INK Advantage, 3525, 4615, 4625, 5525', 'Rendimiento: 250 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240314235811_lbRiK5riBI.webp',
                '2024-03-14 23:58:11',
                '2024-03-14 23:58:11', null, 1
            ],
            [
                3, 13, 1, 3, 1,
                'HP 670', 'DeskJet INK Advantage, 3525, 4615, 4625, 5525', 'Rendimiento: 300 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240314235953_xikNtQvmqg.webp',
                '2024-03-14 23:59:53',
                '2024-03-14 23:59:53', null, 1
            ],
            [
                4, 13, 1, 4, 2,
                'HP 670', 'DeskJet INK Advantage, 3525, 4615, 4625, 5525', 'Rendimiento: 300 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315000104_ZXwcfBUxKU.webp',
                '2024-03-15 00:01:04', '2024-03-15 00:01:04', null, 1
            ],
            [
                5, 13, 1, 2, 1,
                'HP 670', 'DeskJet INK Advantage, 3525, 4615, 4625, 5525', 'Rendimiento: 300 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315000221_gbBA6nnmZK.webp',
                '2024-03-15 00:02:21', '2024-03-15 00:02:21', null, 1
            ],
            [
                6, 13, 1, 1, 2,
                'HP 662XL', 'DeskJet INK Advantage, 1015, 1515, 1516, 2515, 2516, 2545, 2546, 2645, 2646, 3515, 3516, 3545, 3546, 3565, 4645, 4646', 'Rendimiento: 360 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315000512_tguM8msFDc.webp',
                '2024-03-15 00:05:12', '2024-03-15 00:05:12', null, 1
            ],
            [
                7, 13, 2, 4, 1,
                '503A', 'Laser Jet CP3505, 3600, 3800', 'Rendimiento: 6000 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315000711_cvXQ2rJZfx.webp',
                '2024-03-15 00:07:11', '2024-03-15 00:07:11', null, 1
            ],
            [
                8, 13, 2, 2, 1,
                '503A', 'Laser Jet CP3505, 3600, 3800', 'Rendimiento: 6000 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315000846_qsiDjKBUwj.webp',
                '2024-03-15 00:08:46', '2024-03-15 00:08:46', null, 1
            ],
            [
                9, 13, 2, 3, 2,
                '503A', 'Laser Jet CP3505, 3600, 3800', 'Rendimiento: 6000 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315001020_hvoNixAheS.webp',
                '2024-03-15 00:10:20', '2024-03-15 00:10:20', null, 1
            ],
            [
                10, 13, 2, 1, 3,
                '53A', 'Laser Jet P2010, P2014, P2015, M2727 MFP', 'Rendimiento: 3000 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315001150_sdNV7tgIbe.webp',
                '2024-03-15 00:11:50', '2024-03-15 00:11:50', null, 1
            ],
            [
                11, 3, 2, 1, 1,
                '104', 'Fax Phone L120, L90, Image Class D420, D480, MF-4100, 4150, 4270, 4350D, 4370DN, 4600, 4690.', 'Rendimiento: 2100 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315001320_rdQu1PUCJ0.webp',
                '2024-03-15 00:13:20', '2024-03-15 00:13:20', null, 1
            ],
            [
                12, 2, 2, 1, 1,
                'TN-110', 'DCP 9040CN, DCP 9045CDN HL 4040CN, HL 4070CDW, MFC 9440CN, MFC 9840CDW.', 'Rendimiento: 2500 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315001451_pEmaPWoMtD.webp',
                '2024-03-15 00:14:51', '2024-03-15 00:14:51', null, 1
            ],
            [
                13, 2, 2, 3, 3,
                'TN-110', 'DCP 9040CN, DCP 9045CDN HL 4040CN, HL 4070CDW, MFC 9440CN, MFC 9840CDW', 'Rendimiento: 1500 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315001654_LAvWlbwc2T.webp',
                '2024-03-15 00:16:54', '2024-03-15 00:16:54', null, 1
            ],
            [
                14, 3, 1, 5, 1,
                'CL-146', 'Pixma MG2410, MG2510.', 'Rendimiento: 180 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315001726_kB3idh7l0j.webp',
                '2024-03-15 00:17:26', '2024-03-15 00:17:26', null, 1
            ],
            [
                15, 2, 2, 4, 1,
                'TN-110', 'DCP 9040CN, DCP 9045CDN HL 4040CN, HL 4070CDW, MFC 9440CN, MFC 9840CDW', 'Rendimiento: 1500 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315001837_v5HvnOHapS.webp',
                '2024-03-15 00:18:37', '2024-03-15 00:18:37', null, 1
            ],
            [
                16, 2, 2, 2, 1,
                'TN-110', 'DCP 9040CN, DCP 9045CDN HL 4040CN, HL 4070CDW, MFC 9440CN, MFC 9840CDW', 'Rendimiento: 1500 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315002000_OiYmxt5SGO.webp',
                '2024-03-15 00:20:00', '2024-03-15 00:20:00', null, 1
            ],
            [
                17, 7, 1, 4, 1,
                'T-0472', 'Stylus C63, C65, C83, C85, CX3500, CX4500, CX6300, CX6500.', 'Rendimiento: 250 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315002015_4Y0qVNrjNw.webp',
                '2024-03-15 00:20:15', '2024-03-15 00:20:15', null, 1
            ],
            [
                18, 2, 2, 2, 3,
                'TN-210', 'HL-3040CN, HL370CW, MFC-9010CN, MFC-9120CN, MFC-9320CW', 'Rendimiento: 1400 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315002321_Ak8TART8w1.webp',
                '2024-03-15 00:23:21', '2024-03-15 00:23:21', null, 1
            ],
            [
                19, 2, 2, 4, 1,
                'TN-210', 'HL-3040CN, HL370CW, MFC-9010CN, MFC-9120CN, MFC-9320CW', 'Rendimiento: 1400 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315002453_owHb12BbKg.webp',
                '2024-03-15 00:24:53', '2024-03-15 00:24:53', null, 1
            ],
            [
                20, 2, 2, 1, 1,
                'TN-210', 'HL-3040CN, HL370CW, MFC-9010CN, MFC-9120CN, MFC-9320CW', 'Rendimiento: 2200 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315002627_WHYqDn3Ppe.webp',
                '2024-03-15 00:26:27', '2024-03-15 00:26:27', null, 1
            ],
            [
                21, 2, 2, 3, 1,
                'TN-210', 'HL-3040CN, HL370CW, MFC-9010CN, MFC-9120CN, MFC-9320CW', 'Rendimiento: 1400 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315002750_pKemRCNFws.webp',
                '2024-03-15 00:27:50', '2024-03-15 00:28:33', null, 1
            ],
            [
                22, 7, 1, 2, 1,
                'T195', 'XP-101, 201, 204, 211, 214, 401, WF-2532.', 'Rendimiento: 210 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315002846_gqDnIllQUh.webp',
                '2024-03-15 00:28:46', '2024-03-15 00:28:46', null, 1
            ],
            [
                23, 2, 2, 2, 2,
                'TN-221', 'MFC 9130CW, MFC 9130DW', 'Rendimiento: 2200 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315003016_GFo9RM4YCW.webp',
                '2024-03-15 00:30:16', '2024-03-15 00:30:16', null, 1
            ],
            [
                24, 2, 2, 3, 1,
                'TN-221', 'MFC 9130CW, MFC 9130DW', 'Rendimiento: 2200 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315003126_7mmETArnqS.webp',
                '2024-03-15 00:31:26', '2024-03-15 00:31:26', null, 1
            ],
            [
                25, 2, 1, 1, 2,
                'LC51BK', 'DCP-130C, 330C, 350C, 540CN, 560CN, 750WN, 750CW, 770CW, MFC-230C, 240C, 440CN, 465CN, 660CN, 665CW, 680CN, 685CW, 845CW, 885CW, 3360CN, 5460CN, 5860CN',
                'Rendimiento: 500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315003259_UHx7OGMgDE.webp',
                '2024-03-15 00:32:59', '2024-03-15 00:32:59', null, 1
            ],
            [
                26, 7, 1, 4, 1,
                'T-1402', 'TX560WD, TX525FW, TX620FWD.', 'Rendimiento: 755 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315003348_8AScO28bOX.webp',
                '2024-03-15 00:33:48', '2024-03-15 00:33:48', null, 1
            ],
            [
                27, 2, 1, 3, 3,
                'LC51C', 'DCP-130C, 330C, 350C, 540CN, 560CN, 750WN, 750CW, 770CW, MFC-230C, 240C, 440CN, 465CN, 660CN, 665CW, 680CN, 685CW, 845CW, 885CW, 3360CN, 5460CN, 5860CN',
                'Rendimiento: 400 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315003443_iBqXZ6tNAk.webp',
                '2024-03-15 00:34:43', '2024-03-15 00:34:43', null, 1
            ],
            [
                28, 7, 1, 1, 1,
                'T-1401', 'TX560WD, TX620FWD.', 'Rendimiento: 945 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315003502_MdgPFQCK4j.webp',
                '2024-03-15 00:35:02', '2024-03-15 00:35:02', null, 1
            ],
            [
                29, 2, 1, 4, 2,
                'LC51M', 'DCP-130C, 330C, 350C, 540CN, 560CN, 750WN, 750CW, 770CW, MFC-230C, 240C, 440CN, 465CN, 660CN, 665CW, 680CN, 685CW, 845CW, 885CW, 3360CN, 5460CN, 5860CN',
                'Rendimiento: 400 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315003611_baX02QGyVZ.webp',
                '2024-03-15 00:36:11', '2024-03-15 00:36:11', null, 1
            ],
            [
                30, 23, 2, 1, 1,
                'SCX-6320', 'SCX-6322DN, SCX-6122FN, SCX-6320F y SCX-6220.', 'Rendimiento: 8000 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315003634_qy24ZnFKgD.webp',
                '2024-03-15 00:36:34', '2024-03-15 00:36:34', null, 1
            ],
            [
                31, 2, 1, 2, 1,
                'LC51Y', 'DCP-130C, 330C, 350C, 540CN, 560CN, 750WN, 750CW, 770CW, MFC-230C, 240C, 440CN, 465CN, 660CN, 665CW, 680CN, 685CW, 845CW, 885CW, 3360CN, 5460CN, 5860CN',
                'Rendimiento: 400 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315003730_3uhMSCJftv.webp',
                '2024-03-15 00:37:30', '2024-03-15 00:37:30', null, 1
            ],
            [
                32, 27, 5, 1, 1,
                'Micro SD Canvas Select', 'SDCS/32GB',
                'Ideal para almacenamiento de información, fotos, videos, etc. Esta versión permite una mayor velocidad de lectura, permitiendo procesar mayor información en menor tiempo.',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004357_SryYH5nJdw.webp',
                '2024-03-15 00:43:57', '2024-03-15 00:43:57', null, 1
            ],
            [
                33, 23, 2, 1, 1,
                'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas',
                'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp',
                '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1
            ],
            [34, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [35, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [36, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [37, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [38, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [39, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [40, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [41, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [42, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [43, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [44, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [45, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [46, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [47, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [48, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [49, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [50, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [51, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [52, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [53, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [54, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [55, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [56, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [57, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [58, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [59, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [60, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [61, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [62, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [63, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [64, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [65, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [66, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [67, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [68, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [69, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [70, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [71, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [72, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [73, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [74, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [75, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [76, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [77, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [78, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [79, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [80, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [81, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [82, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [83, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [84, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [85, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [86, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [87, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [88, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [89, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [90, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [91, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [92, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [93, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [94, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [95, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [96, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [97, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [98, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [99, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],

            [100, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [101, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [102, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [103, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [104, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [105, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [106, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [107, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [108, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [109, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [110, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [111, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [112, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [113, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [114, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [115, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [116, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [117, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [118, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [119, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [120, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [121, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [122, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [123, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [124, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [125, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [126, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [127, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [128, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [129, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [130, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [131, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [132, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [133, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],

            [134, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [135, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [136, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [137, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [138, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [139, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [140, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [141, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [142, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [143, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [144, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [145, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [146, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [147, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [148, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [149, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [150, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [151, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [152, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [153, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [154, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [155, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [156, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [157, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [158, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [159, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [160, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [161, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [162, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [163, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [164, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [165, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [166, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [167, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [168, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [169, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [170, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [171, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [172, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [173, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [174, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [175, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [176, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [177, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [178, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [179, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [180, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [181, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [182, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [183, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [184, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [185, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [186, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [187, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [188, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [189, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [190, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [191, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [192, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [193, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [194, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [195, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [196, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [197, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [198, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [199, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [200, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [201, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [202, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [203, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [204, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [205, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [206, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [207, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [208, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [209, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [210, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [211, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [212, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [213, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [214, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [215, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [216, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [217, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [218, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [219, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [220, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [221, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [222, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [223, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [224, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
            [225, 23, 2, 1, 1, 'ML-117', 'SCX 4655FN, 4650.', 'Rendimiento: 2500 Paginas', 'https://administrativo.ecotonerdelsureste.com/imagenProductos/producto_1_20240315004428_Cu254tteLn.webp', '2024-03-15 00:44:28', '2024-03-15 00:44:28', null, 1],
        ];

        foreach ($productos as $producto) {
            productos::create([
                'id' => $producto[0],
                'id_marca' => $producto[1],
                'id_tipo' => $producto[2],
                'id_color' => $producto[3],
                'id_modo' => $producto[4],
                'nombre_comercial' => $producto[5],
                'modelo' => $producto[6],
                'descripcion' => $producto[7],
                'fotografia' => $producto[8],
                'created_at' => $producto[9],
                'updated_at' => $producto[10],
                'deleted_at' => $producto[11],
                'estatus' => $producto[12]
            ]);
        }
    }
}
