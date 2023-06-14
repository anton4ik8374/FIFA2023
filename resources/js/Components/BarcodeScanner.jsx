//https://dev.to/zodiapps/how-to-scan-barcodes-in-your-reactjs-application-2668
//https://habr.com/ru/articles/358966/
import { BrowserMultiFormatReader, DecodeHintType, Result } from '@zxing/library';
import { useEffect, useMemo, useRef } from 'react';
import {soundClick} from "@/Helpers/Helpers";


const useZxing = ({
                      constraints = {
                          audio: false,
                          video: {
                              facingMode: 'environment',
                          },
                      },
                      hints,
                      timeBetweenDecodingAttempts = 300,
                      onResult = () => {},
                      onError = () => {},
                  }) => {
    const ref = useRef(null);

    const reader = useMemo(() => {
        const instance = new BrowserMultiFormatReader(hints);
        instance.timeBetweenDecodingAttempts = timeBetweenDecodingAttempts;
        return instance;
    }, [hints, timeBetweenDecodingAttempts]);

    useEffect(() => {
        if (!ref.current) return;
        reader.decodeFromConstraints(constraints, ref.current, (result, error) => {
            if (result){
                soundClick();
                onResult(result);
            }
            if (error) {
                //soundClick('error');
                onError(error);
            }
        });
        return () => {
            reader.reset();
        };
    }, [ref, reader]);

    return { ref };
};

export const BarcodeScanner = ({onResult = () => {},onError = () => {}}) => {
    /**
     * onResult = text
     * t — timestamp, время, когда вы осуществили покупку
     * s — сумма чека
     * fn — кодовый номер fss, потребуется далее в запросе к API
     * i — номер чека, он нам потребуется далее в запросе к API
     * fp — параметр fiscalsign, потребуется далее в запросе к API
     * n=1                  Вид чека
     */
    const { ref } = useZxing({ onResult, onError });
    return <video ref={ref} />;
};
