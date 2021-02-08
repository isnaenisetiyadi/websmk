import Index from '../components/Index.vue';
import HubungiKami from '../components/HubungiKami.vue';
import Berita from '../components/Berita/Index.vue';
import BeritaItem from '../components/Berita/BeritaItem.vue';
import Pengumuman from '../components/Pengumuman/Index.vue';
import Siswa from '../components/Awards/Siswa.vue';
import Guru from '../components/Awards/Guru.vue';
import Galeri from '../components/Galeri/Index.vue';
import Jurusan from '../components/Jurusan/Index.vue';
import Atph from '../components/Jurusan/Atph.vue';
import Apat from '../components/Jurusan/Apat.vue';
import Akl from '../components/Jurusan/Akl.vue';
import Tkj from '../components/Jurusan/Tkj.vue';
import Osis from '../components/Organisasi/Osis.vue';
import Pramuka from '../components/Organisasi/Pramuka.vue';
import Jujitsu from '../components/Organisasi/Jujitsu.vue';
import Psht from '../components/Organisasi/Psht.vue';
import Multimedia from '../components/Organisasi/Multimedia.vue';
import BeritaEntry from '../components/Entry/Berita.vue';
import Pricing from '../components/Pricing/Index.vue';
import Web from '../components/Web/Index.vue';
import Login from '../components/Auth/Login.vue';
import Register from '../components/Auth/Register.vue';
import UserUpdate from '../components/Auth/Update.vue';
import Users from '../components/Auth/Index.vue';

import JurusanViewer from '../components/Jurusan/Viewer.vue';
import OrganisasiViewer from '../components/Organisasi/Viewer.vue';

import Gurus from '../pages/Guru/Index.vue';
import GuruTambah from '../components/Guru/GuruTambah.vue';

import Jurusans from '../pages/Jurusan/Index.vue';

import OrganisasiEntry from '../pages/Organisasi/Index.vue';
import ProgramEntry from '../pages/Program/Index.vue';

const userId = '';
export default [
    { path: '/', component: Index },
    { path: '/berita', component: Berita },
    { path: '/beritaitem', component: BeritaItem },
    { path: '/pengumuman', component: Pengumuman },
    { path: '/galeri', component: Galeri },
    { path: '/awards/siswa', component: Siswa },
    { path: '/awards/guru', component: Guru },
    { path: '/jurusan', component: Jurusan },
    { path: '/jurusan/viewer', component: JurusanViewer },
    { path: '/jurusan/atph', component: Atph },
    { path: '/jurusan/apat', component: Apat },
    { path: '/jurusan/akl', component: Akl },
    { path: '/jurusan/tkj', component: Tkj },
    { path: '/organisasi/osis', component: Osis },
    { path: '/organisasi/pramuka', component: Pramuka },
    { path: '/organisasi/jujitsu', component: Jujitsu },
    { path: '/organisasi/viewer', component: OrganisasiViewer },
    { path: '/organisasi/psht', component: Psht },
    { path: '/organisasi/multimedia', component: Multimedia },
    { path: '/organisasi/entry', component: OrganisasiEntry },
    { path: '/program/entry', component: ProgramEntry },

    {
        path: '/entry/berita',
        component: BeritaEntry,
        name: 'register',
        meta: { login: true }
    },

    { path: '/entry/login', component: Login, meta: { guest: true } },
    { path: '/entry/register', component: Register },
    { path: '/entry/update/:id', component: UserUpdate, name: 'userupdate' },
    {
        path: '/users',
        component: Users,
        name: 'users',
        meta: { login: true }
    },
    { path: '/pricing', component: Pricing },
    { path: '/web', component: Web },
    { path: '/hubungikami', component: HubungiKami },

    { path: '/gurus', component: Gurus },
    { path: '/guru/tambah', component: GuruTambah },

    { path: '/jurusans', component: Jurusans },
]