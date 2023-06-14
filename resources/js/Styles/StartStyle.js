const StartStyle = {
    main: {
        minHeight: '100vh',
        pt: 11
    },
    start: {
        flexGrow: 1,
        position: 'relative',
        width: '100%',
        overflow: 'hidden'
    },
    paralax: {
        background: 'url("/images/backgrounds/background_1.jpg") center top / cover no-repeat fixed',
        position: 'fixed',
        width: '100%',
        height: '100vh',
    },
    clearfix: {
        position: 'relative',
        display: 'flex',
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
    },
    container: {
        position: 'relative',
        overflow: 'hidden',
        bgcolor: 'background.inactive',
        pt: 8,
        pb: 6,
    },
    shadows: {
        pt: '100vh',
        background: 'linear-gradient(to bottom, rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 56%,rgba(0,0,0,0.65) 100%) !important'
    },
    paralaxText: {
        position: 'absolute',
        top: 177,
        zIndex: 20,
        color: '#EEE',
        fontSize: '1.375rem',
        fontWeight: '300',
        textShadow: '1px 1px 1px rgb(0 0 0 / 15%)',
        transition: 'top .3s ease',
    },
    paralaxTextH2: {
        fontWeight: 900,
        fontSize: '80px',
        color: '#EEEEEE'
    },
    paralaxTextP: {
        fontSize: '24px',
        color: '#FFFFFF',
        textShadow: '2px 2px 3px #172f38, 1px 1px 1em #a3d6fd',
        fontWeight: '500 !important'
    },
    card: {
        height: '100%',
        display: 'flex',
        flexDirection: 'column',
        bgcolor: 'inherit',
        fontSize: '0.875rem',
        justifyContent: 'center',
        alignItems: 'center'
    },
    head: {
        color: '#FFF',
        mb: 4,
        textAlign: 'center',
    }
};

export default StartStyle;
